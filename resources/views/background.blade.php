<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Background thing</title>
    <meta name="robots" content="noindex">
    
    <style>
        body {
            background-color: #111;
            margin: 0;
            display: grid;
            place-items: center;
            width: 100vw;
            height: 100vh;
        }

        .home__header {
            aspect-ratio: {{ $aspectratio }};
            
            @if($aspectratio > 1)
            width: 100vw;
            @else 
            height: 100vh;
            @endif

            display: block;
            background-position: center;
            background-origin: border-box;
            background-color: transparent;
            background-image: linear-gradient(to top, rgb(0 0 0 / 0.25) 0%, transparent 2rem),
                radial-gradient(circle at 10px 10px, #707070 1px, transparent 1px),
                radial-gradient(circle at 30px 30px, #404040 1px, transparent 1px);
            background-size: cover, 40px 40px, 40px 40px;

            overflow: clip;
            position: relative;
            z-index: 0;
        }

        .background-component {
            z-index: -1;
            position: absolute;
            display: block;
            aspect-ratio: 1;
            translate: -50% -50%;
        }

        .large-glow {
            width: 50%;
            top: 25%;
            right: -25%;
            border-radius: 50%;
            --opacity: 0.2;
            background-image: linear-gradient(45deg,
                    hsl(50deg 100% 60% / var(--opacity)) 1%,
                    hsl(43deg 100% 60% / var(--opacity)) 22%,
                    hsl(34deg 100% 63% / var(--opacity)) 31%,
                    hsl(22deg 100% 67% / var(--opacity)) 38%,
                    hsl(6deg 100% 71% / var(--opacity)) 44%,
                    hsl(348deg 100% 70% / var(--opacity)) 50%,
                    hsl(334deg 100% 67% / var(--opacity)) 55%,
                    hsl(324deg 100% 66% / var(--opacity)) 61%,
                    hsl(310deg 76% 62% / var(--opacity)) 66%,
                    hsl(283deg 70% 63% / var(--opacity)) 73%,
                    hsl(252deg 80% 67% / var(--opacity)) 81%,
                    hsl(212deg 100% 48% / var(--opacity)) 100%);

            filter: blur(100px);
        }

        .small-glow {
            width: calc(15vw * 0.2 + 20rem * 0.8);
            top: calc(80%);
            left: 60%;
            border-radius: 50%;
            --opacity: 0.2;
            background-image: linear-gradient(10deg,
                    hsl(50deg 100% 60% / var(--opacity)) 1%,
                    hsl(43deg 100% 60% / var(--opacity)) 22%,
                    hsl(34deg 100% 63% / var(--opacity)) 31%,
                    hsl(22deg 100% 67% / var(--opacity)) 38%,
                    hsl(6deg 100% 71% / var(--opacity)) 44%,
                    hsl(348deg 100% 70% / var(--opacity)) 50%,
                    hsl(334deg 100% 67% / var(--opacity)) 55%,
                    hsl(324deg 100% 66% / var(--opacity)) 61%,
                    hsl(310deg 76% 62% / var(--opacity)) 66%,
                    hsl(283deg 70% 63% / var(--opacity)) 73%,
                    hsl(252deg 80% 67% / var(--opacity)) 81%,
                    hsl(212deg 100% 48% / var(--opacity)) 100%);
            filter: blur(40px);
        }

        .left-glow-1 {
            width: 80%;
            top: 120%;
            left: 0;
            border-radius: 50%;
            --opacity: 0.2;
            background-image: linear-gradient(145deg,
                    hsl(50deg 100% 60% / var(--opacity)) 1%,
                    hsl(43deg 100% 60% / var(--opacity)) 22%,
                    hsl(34deg 100% 63% / var(--opacity)) 31%,
                    hsl(22deg 100% 67% / var(--opacity)) 38%,
                    hsl(6deg 100% 71% / var(--opacity)) 44%,
                    hsl(348deg 100% 70% / var(--opacity)) 50%,
                    hsl(334deg 100% 67% / var(--opacity)) 55%,
                    hsl(324deg 100% 66% / var(--opacity)) 61%,
                    hsl(310deg 76% 62% / var(--opacity)) 66%,
                    hsl(283deg 70% 63% / var(--opacity)) 73%,
                    hsl(252deg 80% 67% / var(--opacity)) 81%,
                    hsl(212deg 100% 48% / var(--opacity)) 100%);
            filter: blur(200px) brightness(0.75) saturate(1.5);
        }

        .left-small-glow-2 {
            width: calc(15vw * 0.2 + 20rem * 0.8);
            top: 25%;
            left: 25%;
            border-radius: 50%;
            --opacity: 0.1;
            background-image: linear-gradient(10deg,
                    hsl(50deg 100% 60% / var(--opacity)) 1%,
                    hsl(43deg 100% 60% / var(--opacity)) 22%,
                    hsl(34deg 100% 63% / var(--opacity)) 31%,
                    hsl(22deg 100% 67% / var(--opacity)) 38%,
                    hsl(6deg 100% 71% / var(--opacity)) 44%,
                    hsl(348deg 100% 70% / var(--opacity)) 50%,
                    hsl(334deg 100% 67% / var(--opacity)) 55%,
                    hsl(324deg 100% 66% / var(--opacity)) 61%,
                    hsl(310deg 76% 62% / var(--opacity)) 66%,
                    hsl(283deg 70% 63% / var(--opacity)) 73%,
                    hsl(252deg 80% 67% / var(--opacity)) 81%,
                    hsl(212deg 100% 48% / var(--opacity)) 100%);
            filter: blur(20px);
        }
    </style>
</head>

<body>
    <header class="home__header">
        <div class="background-component large-glow"></div>
        <div class="background-component small-glow"></div>
        <div class="background-component left-glow-1"></div>
        <div class="background-component left-small-glow-2"></div>
    </header>
</body>

</html>