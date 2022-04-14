<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Drag & Drop multiple images uploading using Pure JavaScript</title>
    <link rel="stylesheet" type="text/css" href="app.css">
</head>

<body>
    <style>
        *,
        ::after,
        ::before {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            background: #dfe3f2;
        }

        .card {
            width: 400px;
            height: auto;
            padding: 15px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.15);
            border-radius: 5px;
            overflow: hidden;
            background: #fafbff;
        }

        .card .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .card .top p {
            font-size: 0.9rem;
            font-weight: 600;
            color: #878a9a;
        }

        .card .top button {
            outline: 0;
            border: 0;
            -webkit-appearence: none;
            background: #5256ad;
            color: #fff;
            border-radius: 4px;
            transition: 0.3s;
            cursor: pointer;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.15);
            font-size: 0.8rem;
            padding: 8px 13px;
        }

        .card .top button:hover {
            opacity: 0.8;
        }

        .card .top button:active {
            transform: translateY(5px);
        }

        form {
            width: 100%;
            height: 160px;
            border-radius: 5px;
            border: 2px dashed #d5d5e1;
            color: #c8c9dd;
            font-size: 0.9rem;
            font-weight: 500;
            position: relative;
            background: #dfe3f259;
            display: flex;
            justify-content: center;
            align-items: center;
            user-select: none;
            margin-top: 20px;
        }

        form .select {
            color: #5256ad;
            margin-left: 7px;
            cursor: pointer;
        }

        form input {
                {
                    {
                    display: none;
                }
            }
        }

        form.dragover {
            border-style: solid;
            font-size: 2rem;
            color: #c8c9dd;
            font-weight: 600;
            background: rgba(0, 0, 0, 0.34);
        }

        .container {
            width: 100%;
            display: flex;
            justify-content: flex-start;
            align-items: flex-start;
            flex-wrap: wrap;
            position: relative;
            height: auto;
            margin-top: 20px;
            max-height: 300px;
            overflow-y: auto;
        }

        .container .image {
            height: 85px;
            width: 85px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            position: relative;
            margin-bottom: 7px;
            margin-right: 7px;
        }

        .container .image:nth-child(4n) {
            margin-right: 0;
        }

        .container .image img {
            height: 100%;
            width: 100%;
        }


        .container .image span {
            position: absolute;
            top: -4px;
            right: 5px;
            cursor: pointer;
            font-size: 22px;
            color: #fff;
        }

        .container .image span:hover {
            opacity: 0.8;
        }
    </style>
    <div class="card">
        <div class="top">
            <p>Drag & drop image uploading</p>
            <button type="button">Upload</button>
        </div>
        <form action="/upload" method="post" class="">
            <span class="inner">Drag & drop image here or <span class="select">Browse</span></span>
            <input name="file" type="file" class="file" multiple />
        </form>
        <div class="container"></div>
    </div>

    <script type=text/javascript>
        let files = [], // will be store images
        button = document.querySelector('.top button'), // uupload button
        form = document.querySelector('form'), // form ( drag area )
        container = document.querySelector('.container'), // container in which image will be insert
        text = document.querySelector('.inner'), // inner text of form
        browse = document.querySelector('.select'), // text option fto run input
        input = document.querySelector('form input'); // file input

        browse.addEventListener('click', () => input.click());

        // input change event
        input.addEventListener('change', () => {
            let file = input.files;

            for (let i = 0; i < file.length; i++) {
                if (files.every(e => e.name !== file[i].name)) files.push(file[i])
            }
            form.reset();
            showImages();
        })

        const showImages = () => {
            let images = '';
            files.forEach((e, i) => {
                images += `<div class="image">
                        <img src="${URL.createObjectURL(e)}" alt="image">
                        <span onclick="delImage(${i})">&times;</span>
                    </div>`
            })

            container.innerHTML = images;
        }

        const delImage = index => {
            files.splice(index, 1)
            showImages()
        }

        // drag and drop
        form.addEventListener('dragover', e => {
            e.preventDefault()

            form.classList.add('dragover')
            text.innerHTML = 'Drop images here'
        })

        form.addEventListener('dragleave', e => {
            e.preventDefault()

            form.classList.remove('dragover')
            text.innerHTML = 'Drag & drop image here or <span class="select">Browse</span>'
        })

        form.addEventListener('drop', e => {
            e.preventDefault()

            form.classList.remove('dragover')
            text.innerHTML = 'Drag & drop image here or <span class="select">Browse</span>'

            let file = e.dataTransfer.files;
            for (let i = 0; i < file.length; i++) {
                if (files.every(e => e.name !== file[i].name)) files.push(file[i])
            }

            showImages();
        })

        button.addEventListener('click', () => {
            let form = new FormData();
            files.forEach((e, i) => form.append(`file[${i}]`, e))
        })
    </script>
</body>

</html>
