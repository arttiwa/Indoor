#this code from Arttiwa
import cv2
from ultralytics import YOLO
import time
import os
import subprocess

# Initialize YOLOv8 model
model = YOLO('sign_model.pt')

# Open cam
cap = cv2.VideoCapture(0)

# Set the desired frame rate
target_fps = 2
delay = 1 / target_fps

# Set the new width and height for the resized frames
new_width = 640 
new_height = 480  

# Create the directory to save captured images
cap_directory = r'D:\xampp\htdocs\Indoor\test\yolov8\new_data\cap'
os.makedirs(cap_directory, exist_ok=True)

# Create the directory to save cropped images
output_directory = r'D:\xampp\htdocs\Indoor\test\yolov8\new_data\crop'
os.makedirs(output_directory, exist_ok=True)

#counter
count_pic = 0

while cap.isOpened():
    success, frame = cap.read()

    # Resize the frame before passing it to the model
    resized_frame = cv2.resize(frame, (new_width, new_height))

    try:
        start = time.perf_counter()

        # Run YOLO inference on the resized frame
        result = model(resized_frame)

        end = time.perf_counter()
        total_time = end - start
        fps = 1 / total_time

        # Annotate the resized frame with YOLO results
        annotated_frame = result[0].plot()

        # Display the annotated frame
        cv2.putText(annotated_frame, f"FPS: {int(fps)}", (10, 30), cv2.FONT_HERSHEY_SIMPLEX, 1, (0, 255, 0), 2, cv2.LINE_AA)
        cv2.imshow('YOLO Result', annotated_frame)

        # Check if there are any detections
        if result and result[0].names:
            if result[0].names[0] == 'sign':
                if result[0].boxes is not None and len(result[0].boxes) > 0:
                    x, y, x2, y2 = result[0].boxes.xyxy[0].cpu().numpy().astype(int).tolist()
                    w, h = x2 - x, y2 - y
                    # Crop the region containing the target
                    cropped_image = frame[y:y + h, x:x + w]
                    
                    # # Save the cropped image to the output directory
                    # crop_image_filename = os.path.join(output_directory, f"cropped_{time.time()}.jpg")
                    # cv2.imwrite(crop_image_filename, cropped_image)
                    # print(f"Target detected! Cropped image saved as {crop_image_filename}")
                    
                    # # Save the annotated frame to the output directory
                    # cap_image_filename = os.path.join(cap_directory, f"captured_{time.time()}.jpg")
                    # cv2.imwrite(cap_image_filename, annotated_frame)
                    # print(f"Annotated frame saved as {cap_image_filename}")
                    
                    # Debugging: Print coordinates
                    print(f"Bounding box coordinates: x={x}, y={y}, w={w}, h={h}")
                    
                    count_pic += 1
                    print(count_pic)
                    
                    
                else:
                    print("No bounding box coordinates available.")
            else:
                print("No 'sign' detected.")
        else:
            print("No detections in the frame.")

         # Sleep to control the processing rate
        
        time.sleep(delay)
        
        # Waiting for user input
        key = cv2.waitKey(1)

        # 'q' to exit
        if key == ord('q'):
            break

        # picture = 3 then exit
        if count_pic == 3:
            break
        
    except Exception as e:
        # Handle exceptions
        print(f"Error: {e}")

# Release the camera and close all windows (in case it's not already done)
cap.release()
cv2.destroyAllWindows()

# Run next Python script
# next_script_path = r'D:\xampp\htdocs\Indoor\test\yolov8\ocr_cal.py'
# subprocess.run(['python', next_script_path])






import cv2
import pytesseract
import os
import re
import shutil
import json
import logging
from PIL import Image
from difflib import SequenceMatcher

# Configure logging
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

# Path to the Tesseract executable (change this to your Tesseract installation path)
pytesseract.pytesseract.tesseract_cmd = r'C:\Program Files\Tesseract-OCR\tesseract.exe'
cap_directory = r'D:\xampp\htdocs\Indoor\test\yolov8\new_data\crop'
received_data_file = "received_data.json"

def extract_alphanumeric(text):
    # Extract alphanumeric characters from the OCR result
    return re.sub(r'[^A-Za-z0-9]', '', text)

def similar(a, b):
    # Function to calculate similarity between two strings
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
    # Grayscale
    gray_image = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
    # Apply additional thresholding to improve text visibility
    _, thresholded_image = cv2.threshold(gray_image, 0, 255, cv2.THRESH_BINARY + cv2.THRESH_OTSU)
    
    # Perform OCR on the thresholded image, specifying a whitelist for alphanumeric characters
    recognized_text = pytesseract.image_to_string(
        thresholded_image, lang=lang, config='--psm 6 -c tessedit_char_whitelist=0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz')
    return recognized_text

def main():
    # Load database entries
    try:
        with open(received_data_file, "r") as file:
            database_entries = json.load(file)
    except FileNotFoundError:
        logger.error(f"File not found: {received_data_file}")
        return
    except json.JSONDecodeError:
        logger.error(f"Error decoding JSON in file: {received_data_file}")
        return

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

        # # Print the result
        # logger.info(f"OCR Result for {image_file}: {text_result}")
        # logger.info("Matches in the database:")
        # for entry, similarity in matches:
        #     logger.info(f"{entry}: {similarity} similarity")

        # Save the result with the most similarity
        if most_similarity is None or matches[0][1] > most_similarity[2]:
            most_similarity = (text_result, matches[0][0], matches[0][1])
            
        #logger.info("- " * 15)

    # Check if no similarity is greater than 0.6 first is ocr second is database
    if most_similarity is not None and most_similarity[2] <= 0.6:
        logger.info(f"No entry has similarity greater than 0.6. The most similar matched with-->{most_similarity[0]}<-- matched with>>>{most_similarity[1]}<<< Similarity000{most_similarity[2]}000")
    else:
        logger.info(f"Most similar result: matched with-->{most_similarity[0]}<-- matched with>>>{most_similarity[1]}<<< Similarity000{most_similarity[2]}000")

    # Move files to the calculated_data directory
    calculated_data_directory = r'D:\xampp\htdocs\Indoor\test\yolov8\calculated_data'

    for subdirectory in ['crop', 'cap']:
        source_directory = os.path.join(r'D:\xampp\htdocs\Indoor\test\yolov8\new_data', subdirectory)
        destination_directory = os.path.join(calculated_data_directory, subdirectory)
        
        for filename in os.listdir(source_directory):
            src_path = os.path.join(source_directory, filename)
            dest_path = os.path.join(destination_directory, filename)
            shutil.move(src_path, dest_path)

if __name__ == "__main__":
    main()




