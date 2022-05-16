<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
        <style>
            .dz-image img {
                width: 100%;
                height: 100%;
            }
            .dropzone.dz-started .dz-message {
                display: block !important;
            }
            .dropzone {
                border: 2px dashed #028AF4 !important;;
            }
            .dropzone .dz-preview.dz-complete .dz-success-mark {
                opacity: 1;
            }
            .dropzone .dz-preview.dz-error .dz-success-mark {
                opacity: 0;
            }
            .dropzone .dz-preview .dz-error-message{
                top: 144px;
            }
        </style>
    </head>
    <body>
        <div class="container" >
            <a href="{{ route('fizzbuzz.index') }}">Fizz buzz</a>
            <a href="{{ route('upload.image') }}">Fizz buzz</a>
            <a href="{{ route('hotel.index') }}">Fizz buzz</a>
            <div class="row">
                <div class="col-md-12 mt-5">
                    <h3 class="jumbotron">Laravel Multiple Images Upload Using Dropzone</h3>
                    <form method="post" action="{{url('image/upload/store')}}" enctype="multipart/form-data" class="dropzone" id="dropzone">
                        @csrf
                    </form>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            Dropzone.options.dropzone =
                {
                    maxFilesize: 12,
                    renameFile: function(file) {
                        var dt = new Date();
                        var time = dt.getTime();
                        return time+file.name;
                    },
                    acceptedFiles: ".jpeg,.jpg,.png,.gif",
                    addRemoveLinks: true,
                    timeout: 5000,
                    init:function() {

                    {{--    // Get images--}}
                        var myDropzone = this;
                        $.ajax({
                            url: "{{ url('images') }}",
                            type: 'GET',
                            dataType: 'json',
                            success: function(data){
                                console.log(data);
                                $.each(data, function (key, value) {
                                    var file = {name: value.name};
                                    myDropzone.options.addedfile.call(myDropzone, file);
                                    myDropzone.options.thumbnail.call(myDropzone, file, value.path);
                                    myDropzone.emit("complete", file);
                                });
                            }
                        });
                    },
                    removedfile: function(file)
                    {
                        if (this.options.dictRemoveFile) {
                            return Dropzone.confirm("Are You Sure to "+this.options.dictRemoveFile, function() {
                                if(file.previewElement.id != ""){
                                    var name = file.previewElement.id;
                                }else{
                                    var name = file.name;
                                }
                                //console.log(name);
                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    type: 'POST',
                                    url: "{{ url('image/delete') }}",
                                    data: {filename: name},
                                    success: function (data){
                                        alert(data.success +" File has been successfully removed!");
                                    },
                                    error: function(e) {
                                        console.log(e);
                                    }});
                                var fileRef;
                                return (fileRef = file.previewElement) != null ?
                                    fileRef.parentNode.removeChild(file.previewElement) : void 0;
                            });
                        }
                    },
                    success: function(file, response)
                    {
                        console.log(response);
                    },
                    error: function(file, response)
                    {
                        return false;
                    }
                };
        </script>
    </body>
</html>
