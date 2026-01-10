import os
import time
import json # Import json di global scope
import yt_dlp
import google.generativeai as genai
from flask import Flask, request, jsonify
from flask_cors import CORS

# =========================
# 1. KONFIGURASI API
# =========================
# Gunakan Environment Variable untuk API KEY agar aman di Railway (Best Practice)
# Atau biarkan hardcode jika memang untuk testing cepat, tapi hati-hati.
GOOGLE_API_KEY = os.environ.get("GOOGLE_API_KEY", "AIzaSyC_klJAG8fEwQvyYDH_xn7TdzSjPPHxyhM") 
genai.configure(api_key=GOOGLE_API_KEY)

app = Flask(__name__)
CORS(app) 

# =========================
# 2. FUNGSI DOWNLOADER (TIDAK DIUBAH)
# =========================
def download_video(url):
    print(f"📥 Sedang mengunduh: {url}")
    ydl_opts = {
        'format': 'best',
        'outtmpl': 'temp_video.mp4',
        'quiet': True,
        'no_warnings': True,
        'overwrites': True
    }
    try:
        if os.path.exists('temp_video.mp4'):
            os.remove('temp_video.mp4')
            
        with yt_dlp.YoutubeDL(ydl_opts) as ydl:
            ydl.download([url])
        return "temp_video.mp4"
    except Exception as e:
        print(f"Error Download: {e}")
        return None

# =========================
# 3. FUNGSI AI VALIDATOR (TIDAK DIUBAH)
# =========================
def validate_content(file_path, misi_id):
    model = genai.GenerativeModel("models/gemini-2.5-flash") 
    
    print("🤖 Mengunggah ke AI...")
    video_file = genai.upload_file(path=file_path)

    while video_file.state.name == "PROCESSING":
        time.sleep(1)
        video_file = genai.get_file(video_file.name)

    prompt_spesifik = ""
    # Pastikan konversi ke int aman
    try:
        misi_id_int = int(misi_id)
    except:
        misi_id_int = -1

    if misi_id_int == 0: 
        prompt_spesifik = "Video harus menampilkan buah kelapa muda, es kelapa, atau orang minum air kelapa."
    elif misi_id_int == 1: 
        prompt_spesifik = ""
    elif misi_id_int == 2: 
        prompt_spesifik = ""
    elif misi_id_int == 3: 
        prompt_spesifik = ""
    elif misi_id_int == 4: 
        prompt_spesifik = ""
    else:
        prompt_spesifik = "selain itu, invalid !"

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
    
    try: genai.delete_file(video_file.name)
    except: pass
    
    return response.text

# =========================
# 4. ENDPOINT API
# =========================
@app.route('/', methods=['GET']) # Route tambahan untuk cek status server
def health_check():
    return "Server AI Validator is Running!", 200

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
        clean_text = hasil_teks.replace("```json", "").replace("```", "").strip()
        hasil_json = json.loads(clean_text)
        
    except Exception as e:
        hasil_json = {"status": "error", "alasan": f"AI Error: {str(e)}"}

    # 3. Cleanup
    try:
        if os.path.exists(path):
            os.remove(path)
            print(f"🗑️ File {path} berhasil dihapus dari server.")
    except Exception as e:
        print(f"⚠️ Gagal menghapus file: {e}")

    # 4. Berikan hasil
    return jsonify(hasil_json)

# =========================
# 5. ENTRY POINT (KOMPATIBILITAS RAILWAY)
# =========================
if __name__ == '__main__':
    # Railway menyediakan port melalui variabel lingkungan 'PORT'
    # Jika tidak ada (lokal), gunakan 5000
    port = int(os.environ.get("PORT", 5000))
    print(f"🔥 Server AI Validator Siap di Port {port}!")
    
    # Host '0.0.0.0' wajib untuk Docker/Railway agar bisa diakses dari luar container
    app.run(host='0.0.0.0', port=port)
