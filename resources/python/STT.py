import speech_recognition as sr
import sys
import librosa
import numpy as np
from scipy.spatial import distance

file =  sys.argv[1]

def recognize_speech():
    # Buat objek recognizer
    recognizer = sr.Recognizer()

    # Buka file audio
    with sr.AudioFile(file) as source:
        # Mendengarkan audio dari file
        audio_data = recognizer.record(source)
        try:
            # Menggunakan recognizer untuk melakukan pengenalan suara
            text = recognizer.recognize_google(audio_data,language='ar')
            return text
        except sr.UnknownValueError:
            return "Pengenalan suara gagal: Tidak dapat mengenali suara"
        except sr.RequestError as e:
            return f"Pengenalan suara gagal: {e}"
        

def audio_to_signal(audio_file):
    # Membaca file audio dan mengonversinya menjadi sinyal suara
    signal, sample_rate = librosa.load(audio_file, sr=None)
    return signal, sample_rate
# Panggil fungsi untuk melakukan pengenalan suara

# recognized_text = recognize_speech()
signal ,rate = audio_to_signal(file)

# Cetak hasil pengenalan suara
# print("Pengenalan suara:", recognized_text)
print("signal suara:", signal[617400:617500] , rate)
