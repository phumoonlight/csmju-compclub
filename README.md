# CSMJU - Computer Club

> management information system [MIS] - project

## Q&A

* ถาม/ตอบปัญหา/ข้อสงสัย ถามมาได้ ยินดีตอบ :blush:  
* https://github.com/phumoonlight/csmju-compclub/issues
* หรือ https://www.facebook.com/ppmeemee

## สำหรับ น้องๆ ที่จะเอาไปทำต่อ

* code ชุดเก่า [`1.0`](https://github.com/phumoonlight/csmju-compclub/releases) จะอยูใน folder `archive`
* ถ้าแกะไม่ออก แนะนำให้จัดโครงสร้างใหม่นะ

## Computer Club - Renovate

จัดแบ่งโครงสร้าง folder structure เตรียมไว้ให้แล้วแบ่งเป็น 

`libs` 

`src` 

`src/components` 

`src/config`

`src/pages`

`src/services`

`src/styles`

`src/utils`

`src` จะเป็นส่วนที่จะลง code

`libs` จะเป็น library ภายนอก เช่น `jquery`, `axios`, `bootstrap`

### ภายใน folder `src`

`components` เก็บ html เป็นส่วนๆ สามารถ ใช้ `require_once` จากหน้า php เวลาแก้ก็แก้แค่ส่วนนี้ส่วนเดียว ไม่ต้องไล่แก้ทุกหน้า 

```php
require_once 'example.html'
```

`config` setup ค่าคงที่ ค่าที่นำไปใช้บ่อยๆ ในหลายๆหน้า

ตัวอย่างการนำ ไปใช้

```html
<script src="example.js"></script>
```

`pages` เก็บหน้าที่เปิดแต่ละหน้าเอาไว้ เช่น `index.php`, `admin.php`

`services` เป็นหน้าสำหรับ ทำ query กับ database
มีส่วนตรวจสอบ `login` กับ หน้าเชื่อมต่อ `database` เตรียมไว้ให้แล้ว

`styles` เก็บ css file แนะนำให้เขียนแยกเป็นส่วนๆ เพื่อง่ายต่อการแก้ไข

`utils` เก็บส่วน function หรือ logic ไว้ที่นี่แล้ว import ไปใช้กับ file อื่นๆ

ตัวอย่างการนำ ไปใช้

```html
<script src="example.js"></script>
```

### การเชื่อมโยงกัน

> แบบเดิมดูไม่ออกเหมือนกับว่า เขียนอะไรลงไปเนี่ย???

ส่วนใหญ่ จะเป็น แบบ `pages <--> php <--> database`

อีกเล็กน้อย จะเป็น `pages <--> javaScript <--> php <--> database`

### แบบที่ควรจะเป็น

`pages <--> javaScript <--> php <--> database`

`javaScript` สามารถติดต่อกับ php ได้โดย ใช้ `ajax` ของ `jquery` หรือ function ของ `axios` 

ตัวอย่างเช่น 

* เปิดหน้า index 
* index จะใช้งาน js ตาม `<script>`
* js จะใช้ `jquery` หรือ `axios` เรียกใช้ `php` 
* php จะ query ข้อมูลจาก `database` ออกมา แล้วส่งให้ฝั่ง `js` ผ่าน `echo 'data'` 
* js จะรับข้อมูลที่ได้จาก php แล้วนำไปใช้งานตามสบาย

### วิธีนี้ จะแยกส่วน `frontend` กับ `backend` ออกอย่างชัดเจน

