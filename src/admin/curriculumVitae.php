<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>職務経歴書</title>
    <style>
        .pdf-container {
            width: 100%;
            height: 600px; /* デフォルトの高さ */
        }
        @media (max-width: 768px) {
            .pdf-container {
                height: 400px; /* スマートフォンなどの小さい画面のための高さ */
            }
        }
        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>
<body>
    <h1>職務経歴書</h1>
    <div class="pdf-container">
        <iframe src="../../public/PDF/職務経歴書.pdf"></iframe>
    </div>
    <p><a href="../../public/PDF/職務経歴書.pdf" download>Download PDF</a></p>
</body>
</html>
