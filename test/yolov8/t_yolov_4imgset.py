import cv2
from ultralytics import YOLO
import os

model = YOLO('sign_model.pt')
confidence_threshold = 0.5

# for test with img dataset
# input_directory = r'D:\xampp\htdocs\Indoor\test\yolov8\img_data_set\pic_data_pure'
# output_directory = r'D:\xampp\htdocs\Indoor\test\yolov8\img_data_set\pic_data_cropped'
os.makedirs(output_directory, exist_ok=True)

count_pic = 0
for image_file in os.listdir(input_directory):
    
    image_path = os.path.join(input_directory, image_file)
    frame = cv2.imread(image_path)
    result = model(frame)

    # Check if detections
    if result is not None and result[0] is not None and result[0].names:
        for i, name in enumerate(result[0].names):
            # Use the confidence attribute to get class confidence
            confidence = result[0].scores[i] if hasattr(result[0], 'scores') else 1.0

            # Use the class index if the name is not available
            class_name = model.names[name] if hasattr(model, 'names') and name in model.names else str(name)
            print(f"Detected: {class_name}, Confidence: {confidence}")

            if class_name == 'sign' and confidence > confidence_threshold:
                box = result[0].boxes.xyxy[i].cpu().numpy().astype(int).tolist()
                x, y, x2, y2 = box[0], box[1], box[2], box[3]
                cropped_image = frame[y:y2, x:x2]

                # Save the cropped image to the output directory with a unique index
                count_pic += 1
                crop_image_filename = os.path.join(output_directory, f"cropped_{count_pic}.jpg")
                cv2.imwrite(crop_image_filename, cropped_image)
                print(f"Target detected! Cropped image saved as {crop_image_filename}")

# Release any resources
cv2.destroyAllWindows()
