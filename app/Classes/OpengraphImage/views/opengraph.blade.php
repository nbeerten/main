<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap');

    * {
        box-sizing: border-box;
    }
    
    body {
        margin: 0;
    }

    .main {
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

    .left {
        display: block;
    }

    h1 {
        display: block;
        color: white;
        font-family: Montserrat;
        margin: 0;
        font-size: 4rem;
    }

    p {
        color: #d1d5db;
        margin: 0;
        font-family: Montserrat;
        font-size: 1.5rem;
        margin-left: 3px;
    }

    img {
        display: block;
        height: calc(150px - 4rem);
        aspect-ratio: 1;
    }
</style>
<div class="main">
    <div class="left">
        <h1>{{ $title }}</h1>
        <p>nilsbeerten.nl</p>
    </div>
    <img src="https://nilsbeerten.nl/assets/logo_white.svg">
</div>
