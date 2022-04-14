<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <style>
        .image_container {
            height: 120px;
            width: 200px;
            border-radius: 6px;
            overflow: hidden;

        }

        .image_container img {
            height: 100%;
            width: auto;
            object-fit: cover;
        }

        .image_container span {
            top: -9px;
            right: 85px;
            color: red;
            font-size: 28px;
            font-weight: normal;
            cursor: pointer;

        }
    </style>
    <div class="container mt-3 w-100">
        <div class="card shadow-sm w-100">
            <div class="card-header d-flex justify-content-between">
                <h4>Image Uploading</h4>
                @if(count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form method="post" action="{{  route('admin.file.multipleUpload') }}" enctype="multipart/form-data">
                    @csrf
                    <input class="form-control d-none" type="file" id="image" name="image[]" onchange=(image_select())
                        multiple>
                    <button class="btn btn-sm btn-primary" type="button"
                        onclick="document.getElementById('image').click()">Choose Images</button>
                    {{--  <input type="submit" name="btn_upload">  --}}
                </form>
            </div>
            <div class="card-body d-flex flex-wrap justify-content-start" id="container">
                <div class="image_container d-flex justify-content-start flex-wrap">
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var images = [];
        function image_select() {
            var image = document.getElementById('image').files;
            for (i = 0; i < image.length; i++) {
                  if (check_duplicate(image[i].name)) {
             images.push({
                          "name" : image[i].name,
                          "url" : URL.createObjectURL(image[i]),
                          "file" : image[i],
                    })
                  } else
                  {
                    alert(image[i].name + " đã tồn tại");
                  }
            }

            //document.getElementById('form').reset();
            document.getElementById('container').innerHTML = image_show();
      }

      function image_show() {
        var image = "";
        images.forEach((i) => {
             image += `<div class="image_container d-flex justify-content-center position-relative">
                    <img src="`+ i.url +`" alt="Image" data_name="`+i.name+`">
                    <span class="position-absolute delete_image" onclick="delete_image(`+ images.indexOf(i) +`)">&times;</span>
              </div>`;
        })
        return image;
    }

  function delete_image(e) {
    images.splice(e, 1);
    document.getElementById('container').innerHTML = image_show();
}

function check_duplicate(name) {
    var image = true;
    if (images.length > 0) {
        for (e = 0; e < images.length; e++) {
            if (images[e].name == name) {
                image = false;
                break;
            }
        }
    }
    return image;
}
    </script>
</body>

</html>
