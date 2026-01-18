from PIL import Image
import os

for f in os.listdir('Price_list'):
    if f.endswith(('.jpg', '.JPG')):
        img = Image.open('Price_list/' + f)
        print(f'{f}: {img.size}')
