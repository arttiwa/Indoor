import cv2
import pytesseract
import os
import re
import shutil
from PIL import Image
from difflib import SequenceMatcher

# Path to the Tesseract executable (change this to your Tesseract installation path)
pytesseract.pytesseract.tesseract_cmd = r'C:\Program Files\Tesseract-OCR\tesseract.exe'
cap_directory = r'D:\xampp\htdocs\Indoor\test\yolov8\new_data\crop'

def extract_alphanumeric(text):
    # Extract alphanumeric characters from the OCR result
    return re.sub(r'[^A-Za-z0-9]', '', text)

def similar(a, b):
    # Function calculate similarity between two strings
    return SequenceMatcher(None, a, b).ratio()

def find_matches(ocr_text, database):
    # Extract alphanumeric characters from the OCR result
    alphanumeric_text = extract_alphanumeric(ocr_text)

    # Calculate similarity for each entry in the database
    matches = [(entry, similar(alphanumeric_text, entry)) for entry in database]

    # Sort matches by the number of matching letters in descending order
    sorted_matches = sorted(matches, key=lambda x: x[1], reverse=True)

    return sorted_matches

def ocr_from_image(image_path, lang='eng'):
    image = cv2.imread(image_path)
    # grayscale
    gray_image = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
    # Apply additional thresholding to improve text visibility
    _, thresholded_image = cv2.threshold(gray_image, 0, 255, cv2.THRESH_BINARY + cv2.THRESH_OTSU)
    
    # Perform OCR on the thresholded image, specifying a whitelist for alphanumeric characters
    recognized_text = pytesseract.image_to_string(thresholded_image, lang=lang, config='--psm 6 -c tessedit_char_whitelist=0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz')
    return recognized_text

# Database entries
database_entries = ['B1135', 'B1136', 'B1137', 'B1138']

# Get image files in the cap directory
image_files = [f for f in os.listdir(cap_directory) if f.endswith('.jpg')]

# Initialize most_similarity
most_similarity = None

for image_file in image_files:
    image_path = os.path.join(cap_directory, image_file)

    # Perform OCR on the image
    text_result = ocr_from_image(image_path, lang='eng')

    # Find matches in the database
    matches = find_matches(text_result, database_entries)

    # Print the result
    print(f"OCR Result for {image_file}: {text_result}")
    print("Matches in the database:")
    for entry, similarity in matches:
        print(f"{entry}: {similarity} similarity")

    # Save the result with the most similarity
    if most_similarity is None or matches[0][1] > most_similarity[2]:
        most_similarity = (text_result, matches[0][0], matches[0][1])
        
    print("- " * 15)

# Check if no similarity is greater than 0.6
if most_similarity is not None and most_similarity[2] <= 0.6:
    print(f"No entry has similarity greater than 0.6. The most similar result is {most_similarity[0]} matched with {most_similarity[1]} (Similarity: {most_similarity[2]})")
else:
    print(f"Most similar result: {most_similarity[0]} matched with {most_similarity[1]} (Similarity: {most_similarity[2]})")


# Move files to the calculated_data directory
calculated_data_directory = r'D:\xampp\htdocs\Indoor\test\yolov8\calculated_data'
shutil.move(cap_directory, os.path.join(calculated_data_directory, 'cap'))

# Move files from new_data/crop to calculated_data/crop
crop_directory = r'D:\xampp\htdocs\Indoor\test\yolov8\new_data\crop'
shutil.move(crop_directory, os.path.join(calculated_data_directory, 'crop'))