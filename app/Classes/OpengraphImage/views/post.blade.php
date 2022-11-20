<!DOCTYPE html>
<html>

<head>
    <link rel="preload" href="https://nilsbeerten.nl/fonts/Mona-Sans.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="https://nilsbeerten.nl/fonts/Hubot-Sans.woff2" as="font" type="font/woff2" crossorigin>
    <style>
        @font-face {
            font-family: 'Mona Sans';
            src: url(https://nilsbeerten.nl/fonts/Mona-Sans.woff2) format('woff2 supports variations'),
                url(https://nilsbeerten.nl/fonts/Mona-Sans.woff2) format('woff2-variations');
            font-weight: 200 900;
            font-stretch: 75% 125%;
        }

        @font-face {
            font-family: 'Hubot Sans';
            src: url(https://nilsbeerten.nl/fonts/Hubot-Sans.woff2) format('woff2 supports variations'),
                url(https://nilsbeerten.nl/fonts/Hubot-Sans.woff2) format('woff2-variations');
            font-weight: 200 900;
            font-stretch: 75% 125%;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
        }

        .wrapper {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 600px;
            width: 1200px;
        }

        main {
            background: #171717;
            display: flex;
            align-items: center;
            padding: 0.5rem 2rem;
            flex-grow: 1;
        }

        h1 {
            display: block;
            color: white;
            font-family: "Hubot Sans";
            font-weight: 800;
            margin: 0;
            font-size: 3.5rem;
            font-stretch: 110%;
            max-width: 20ch;
        }

        footer {
            background-color: #171717;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 2rem;
            height: 150px;
            width: 1200px;
            border-top: 1px solid rgb(113 113 122);
        }

        p {
            color: #d1d5db;
            margin: 0;
            font-family: "Mona Sans";
            font-weight: 600;
            font-size: 1.5rem;
            font-stretch: 115%;
            margin-left: 4px;
        }

        img {
            display: block;
            height: calc(150px - 4rem);
            aspect-ratio: 1;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <main>
            <h1>Making Opengraph thumbnails with HTML and CSS using Browsershot</h1>
        </main>
        <footer>
            <p>nilsbeerten.nl</p>
            <img src="https://nilsbeerten.nl/assets/logo_white.svg">
        </footer>
    </div>
</body>

</html>
