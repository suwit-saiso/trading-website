<?php

session_start();
require_once 'config/db.php';


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>
  <div class="px-4 py-5 my-5 text-center">
    <i class="fa-solid fa-eject fa-3x"></i>
    
    <div class="container" style="width: 600px;">
      <h1 class="display-5 fw-bold text-body-emphasis">เกี่ยวกับเรา</h1>
      <h4>
        เราคือแพลตฟอร์มการประมูลออนไลน์ที่นำเสนอโอกาสให้กับผู้คนที่ต้องการซื้อและขายสินค้าหรือบริการในรูปแบบการเสนอราคา (bidding) โดยเป็นส่วนสำคัญของวงการการซื้อขายออนไลน์ที่ก้าวไปข้าหน้าแบบก้าวกระโดด
      </h4>
      <h1 class="display-5 fw-bold text-body-emphasis mt-4">วิสัยทัศน์ของเรา</h1>
      <h4>
        ที่เราจะเป็นตัวกลางที่เชื่อมโยงระหว่างผู้ซื้อและผู้ขายผ่านกระบวนการการประมูลที่เราทำให้เรียบง่ายและสนุกสนาน เราเชื่อในความโปร่งใสและการชิ้นส่วนที่เป็นส่วนตัวของการประมูลออนไลน์ ที่ช่วยสร้างความเชื่อมั่นระหว่างผู้ใช้และรายสินค้าหรือบริการที่พวกเขาต้องการ
      </h4>
    </div>
      <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
        <button type="button" class="btn btn-primary btn-lg px-4 gap-3" onclick="window.history.back();">Back</button>
      </div>
    </div>
  </body>
  
  </html>