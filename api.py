import os
import time
import yt_dlp
import google.generativeai as genai
from flask import Flask, request, jsonify
from flask_cors import CORS

# =========================
# 1. KONFIGURASI API
# =========================
GOOGLE_API_KEY = "AIzaSyC_klJAG8fEwQvyYDH_xn7TdzSjPPHxyhM" # <--- JANGAN LUPA GANTI INI
genai.configure(api_key=GOOGLE_API_KEY)

app = Flask(__name__)
CORS(app) # Ini PENTING agar PHP (XAMPP) bisa ngobrol sama Python

# =========================
# 2. FUNGSI DOWNLOADER
# =========================
def download_video(url):
    print(f"📥 Sedang mengunduh: {url}")
    ydl_opts = {
        'format': 'best',
        'outtmpl': 'temp_video.mp4', # Nama file statis, akan ditimpa setiap request baru
        'quiet': True,
        'no_warnings': True,
        'overwrites': True
    }
    try:
        # Hapus file lama biar bersih
        if os.path.exists('temp_video.mp4'):
            os.remove('temp_video.mp4')
            
        with yt_dlp.YoutubeDL(ydl_opts) as ydl:
            ydl.download([url])
        return "temp_video.mp4"
    except Exception as e:
        print(f"Error Download: {e}")
        return None

# =========================
# 3. FUNGSI AI VALIDATOR (Dinamis)
# =========================
def validate_content(file_path, misi_id):
    model = genai.GenerativeModel("models/gemini-2.5-flash") # atau "gemini-1.5-flash"
    
    print("🤖 Mengunggah ke AI...")
    video_file = genai.upload_file(path=file_path)

    while video_file.state.name == "PROCESSING":
        time.sleep(1)
        video_file = genai.get_file(video_file.name)

    # Tentukan Prompt Berdasarkan Misi yang Dipilih di PHP
    # Urutan ID harus sama dengan array $list_event di PHP (mulai dari 0)
    prompt_spesifik = ""
    if int(misi_id) == 0: # Kelapa Segar
        prompt_spesifik = "Video harus menampilkan buah kelapa muda, es kelapa, atau orang minum air kelapa."
    elif int(misi_id) == 1: # Alat Pancing
        prompt_spesifik = "Video harus menampilkan alat pancing, danau/kolam pemancingan, atau aktivitas memancing."
    elif int(misi_id) == 2: # Ikan Bakar
        prompt_spesifik = "Video harus menampilkan hidangan ikan bakar atau proses membakar ikan."
    elif int(misi_id) == 3: # Rakit
        prompt_spesifik = "Video harus menampilkan orang menaiki rakit/perahu bambu di atas air."
    elif int(misi_id) == 4: # Camping
        prompt_spesifik = "Video harus menampilkan tenda camping atau suasana berkemah."
    else:
        prompt_spesifik = "Video harus menampilkan suasana wisata alam outdoor."

    final_prompt = f"""
    Kamu adalah Validator Lomba.
    Tugas: Cek apakah video ini memenuhi syarat misi: "{prompt_spesifik}"
    
    Jawab HANYA dengan format JSON ini (tanpa markdown):
    {{
        "status": "VALID" atau "INVALID",
        "alasan": "Alasan singkat 1 kalimat"
    }}
    """

    response = model.generate_content([video_file, final_prompt])
    
    # Bersihkan file dari cloud
    try: genai.delete_file(video_file.name)
    except: pass
    
    return response.text

# =========================
# 4. ENDPOINT API (Pintu Masuk PHP)
# =========================
@app.route('/cek-video', methods=['POST'])
def api_handler():
    data = request.json
    link = data.get('url')
    misi_id = data.get('misi_id') 

    if not link:
        return jsonify({"status": "error", "alasan": "Link kosong"})

    # 1. Download Video
    path = download_video(link)
    if not path:
        return jsonify({"status": "error", "alasan": "Gagal download video (Link private/salah)"})

    # 2. Analisis dengan AI
    try:
        hasil_teks = validate_content(path, misi_id)
        
        # Bersihkan text agar jadi JSON valid
        import json
        clean_text = hasil_teks.replace("```json", "").replace("```", "").strip()
        hasil_json = json.loads(clean_text)
        
    except Exception as e:
        hasil_json = {"status": "error", "alasan": f"AI Error: {str(e)}"}

    # 3. PENGHAPUSAN VIDEO (Cleanup)
    # Ini akan menghapus file temp_video.mp4 setelah AI selesai memberikan jawaban
    try:
        if os.path.exists(path):
            os.remove(path)
            print(f"🗑️ File {path} berhasil dihapus dari server lokal.")
    except Exception as e:
        print(f"⚠️ Gagal menghapus file: {e}")

    # 4. Berikan hasil ke PHP
    return jsonify(hasil_json)

if __name__ == '__main__':
    print("🔥 Server AI Validator Siap! (Port 5000)")
    app.run(port=5000)