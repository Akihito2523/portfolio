<?php
session_start();
require_once('../lib/functions.php');
require_once('DataAccessAdmin.php');
require_once("../includes/admin_header.php");
?>

<!-- ローディング画面 -->
<div id="loading">
  <p>Loading...</p>
  <div id="loading-screen"></div>
</div>


<main>
  <div class="mainImage">
    <div id="prevImage" class="prevImage">◀︎</div>
    <div id="nextImage" class="nextImage">▶︎</div>
    <img id="mainImage" alt="">
    <div id="currentSlideNumber" class="currentSlideNumber"></div>
  </div>

  <ul id="imageList" class="imageList"></ul>
</main>



<!-- アコーディオン -->
<details class="details">
  <summary class="details-summary">Q1.アコーディオンのタイトル</summary>
  <p class="details-content">
    ここは、1つ目のアコーディオンの中身です。<br>
    ここは、1つ目のアコーディオンの中身です。<br>
    ここは、1つ目のアコーディオンの中身です。
  </p>
</details>
<details class="details">
  <summary class="details-summary">Q2.アコーディオンのタイトル</summary>
  <p class="details-content">
    ここは、2つ目のアコーディオンの中身です。<br>
    ここは、2つ目のアコーディオンの中身です。<br>
    ここは、2つ目のアコーディオンの中身です。<br>
    ここは、2つ目のアコーディオンの中身です。<br>
    ここは、2つ目のアコーディオンの中身です。<br>
    ここは、2つ目のアコーディオンの中身です。<br>
  </p>
</details>
<details class="details">
  <summary class="details-summary">Q3.アコーディオンのタイトル</summary>
  <p class="details-content">
    ここは、3つ目のアコーディオンの中身です。ここは、3つ目のアコーディオンの中身です。ここは、3つ目のアコーディオンの中身です。ここは、3つ目のアコーディオンの中身です。ここは、3つ目のアコーディオンの中身です。ここは、3つ目のアコーディオンの中身です。ここは、3つ目のアコーディオンの中身です。ここは、3つ目のアコーディオンの中身です。
  </p>
</details>
