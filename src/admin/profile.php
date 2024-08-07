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

<div class="container">

  <h2 class="contents-title">プロフィール</h2>
  <!-- プロフィールカード -->
  <div class="profile-card">
    <div class="profile-card-bg-image">
      <img src="../../public/imageProfile/profile_02.jpg" alt="プロフィール">
    </div>
    <div class="profile-card-icon-image">
      <img src="../../public/imageProfile/profile_01.PNG" alt="プロフィール">
    </div>
    <div class="profile-card-info">
      <h3 class="profile-card-name">鳥山 彰仁</h3>
      <span class="profile-card-alphabet">TORIYAMA AKIHITO</span>
      <div class="profile-card-explanation">
        大阪出身の34歳です。ここ数年間、個人事業主としてPCのキッティング、動画制作、Web制作に携わり、現在はIT企業で活動しています。
        <p class="profile-card-explanation-title">【自己紹介】</p>
        私の長所は、目標達成のための継続力と、学んだ技術を実践し他者の喜びにつなげることです。2020年ごろからは自宅での時間を利用し、動画の撮影・編集やHTML、CSS、JavaScript、PHPなどのWeb言語を独学で学びました。プログラミングを選んだのは、日常で使用するWEBサイトやアプリがどのように動作し、構築されているのかに興味を持ったからです。最初は難しさに何度も挫折しましたが、成功を収めた際の喜びを見据えて努力し続けました。
        <p class="profile-card-explanation-title">【経験と成果】</p>
        独学の経験を活かし、友人のためにウェブサイトを制作し、インターネット上で公開し、成功を経験しました。初めてプログラミングを通じて報酬を得た際は、達成感に満ち溢れ、努力が成果に結びつくことを実感し、勉強を継続するモチベーションを高めました。
        <p class="profile-card-explanation-title">【学歴とスキル】</p>
        学歴はありませんが、毎日の継続力で独自のスキルを磨き、物事を学ぶ速度が他者よりも遅い側面も、努力で克服してきました。
        <p class="profile-card-explanation-title">【人生の挑戦と目標】</p>
        私は人生の挑戦と成長を追求し、一瞬一瞬の時間を大切にして、毎日、自分史上最高の1日にするために変化と成長を求めています。新たな挑戦には成功が保証されているわけではありませんが、自分の夢に向かって挑戦し、努力することが成功と考えています。挑戦しないことだったり、何も得られない状況は失敗だと感じています。
        私の目標はプログラミングの仕事を通じて、自らの挑戦を続け、成果を上げ、成功体験を得ることです。
      </div>

      <div class="profile-card-snsBlock">
        <div class="profile-card-button">
          <div class="profile-card-icon"><i class="fab fa-github"></i></div>
          <a href="https://github.com/Akihito2523/portfolio" class="profile-card-snsLink" target="_blank">Github</a>
        </div>
        <div class="profile-card-button">
          <div class="profile-card-icon"><i class="fab fa-youtube"></i></div>
          <a href="https://www.youtube.com/watch?v=_idXzVS4hrQ&t=74s" class="profile-card-snsLink" target="_blank">Youtube</a>
        </div>
      </div>
    </div>
  </div>

  <h2 class="contents-title">仕事経歴</h2>
  <!-- 仕事 -->
  <div class="box-container">
    <div class="box" data-aos="fade-up" data-aos-delay="150">
      <span class="card-label">2011年10月〜2016年12月</span>
      <div class="image">
        <img src="../../public/imageProfile/work_01.jpg" alt="仕事写真1" />
      </div>
      <div class="content">
        <h3>トラック運送</h3>
        <p>トラックを運転し、自社工場で焼き上げたパンを自社営業所へ配送するお仕事です。
          安全運転を心掛け、荷物が崩れないように細心の注意を払い、事故のないように努めてきました。
          お客様からの信頼を得るために、丁寧で確実な配達を心がけていました。
        </p>
      </div>
    </div>

    <div class="box" data-aos="fade-up" data-aos-delay="300">
      <span class="card-label">2017年1月〜2023年3月</span>
      <div class="image">
        <!-- <img src="../../public/imageProfile/work_02.jpg" alt="仕事写真2" /> -->
        <!-- <iframe width="100%" height="315" src="https://www.youtube.com/embed/動画ID" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
        <iframe width="" height="" src="https://www.youtube.com/embed/_idXzVS4hrQ?si=EV1ltK3lGcDC-hoB" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay=1; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
      </div>
      <div class="content">
        <h3>フリーランス</h3>
        <p>個人事業主としてPCのキッティング、動画制作、Web制作に携わりました。動画作成では、主にブライダルの撮影と編集に携わり、新郎新婦の特別な1日を動画で記録するお仕事をしていました。PCキッティングでは、初期状態のPCやスマートフォンなどを利用できる状態にするお仕事です。</p>
      </div>
    </div>

    <div class="box" data-aos="fade-up" data-aos-delay="450">
      <span class="card-label">2023年4月〜現在</span>
      <div class="image">
        <img src="../../public/imageProfile/work_03.jpg" alt="仕事写真3" />
      </div>
      <div class="content">
        <h3>エンジニア</h3>
        <p>クラウド型ローコード開発プラットフォームを利用し、Webフォームの作成、データベース管理、メール配などをGUI操作で実現するソリューションを提供しています。
          また、プラットフォームで実現できないカスタマイズ部分はPHPやJavaScriptを用いて対応しています。</p>
      </div>
    </div>
  </div>

  <h2 class="contents-title">趣味一覧</h2>
  <!-- 趣味一覧 -->
  <div class="profile-photoSlides">
    <div id="js-prevImage" class="profile-photoSlides-prevImage">◀︎</div>
    <div id="js-nextImage" class="profile-photoSlides-nextImage">▶︎</div>
    <img id="js-mainImage" class="profile-photoSlides-mainImage" alt="趣味の写真">
    <div id="js-currentSlideNumber" class="currentSlideNumber"></div>
  </div>
  <ul id="js-imageList" class="profile-photoSlides-imageList"></ul>

  <h2 class="contents-title">質問</h2>
  <!-- 質問 -->
  <div class="profile-accordion">
    <details class="profile-accordion-details">
      <summary class="profile-accordion-details-summary">Q1. 持っている資格</summary>
      <p class="profile-accordion-details-content">
        ・大型第１種自動車免許<br>
        ・野球知識検定５級<br>
        ・映像音響処理技術者<br>
        ・秘書検定２級<br>
        ・危険物乙種第四類<br>
      </p>
    </details>
    <details class="profile-accordion-details">
      <summary class="profile-accordion-details-summary">Q2. 学習したプログラミング言語</summary>
      <p class="profile-accordion-details-content">
        ・HTML<br>
        ・CSS<br>
        ・JavaScript<br>
        ・PHP<br>
        ・Swift<br>
        ・MySQL<br>
      </p>
    </details>
    <details class="profile-accordion-details">
      <summary class="profile-accordion-details-summary">Q3.この先やってみたいこと</summary>
      <p class="profile-accordion-details-content">
        私は大好きなプログラミングを通じて技術を学び続け、人々の生活をより良くし、社会に貢献していきたいと考えています。プログラマーになりたい理由は、技術の習得が難しく、変化が激しい世界だからこそ、その挑戦と成長の喜びを感じるからです。努力して身につけた技術を活かし、他者の役に立つことが私の最高の幸せな瞬間です。

        これまでの経験を活かして、人生を変えるために新たなプログラミングのチャレンジを求めています。場所にとらわれず、どこでも業務に取り組む意欲があります。
      </p>
    </details>
  </div>

</div>

<?php require_once("../includes/footer.php"); ?>
