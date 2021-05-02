var code = [
"text/css",
"text/html",
"application/javascript",
"text/x-c",
"text/x-java-source,java",
"application/json",
"application/x-latex",
"application/x-lua",
"text/markdown",
"application/x-ocaml",
"text/plain",
"text/x-python",
"application/x-swift"
]

var image =["image/gif","image/jpeg","image/png"];
var pdf = "application/pdf";


function preview(input) {
  //si ce n'est pas vide
	if (input.files && input.files[0]) {
      var file = input.files[0];
    	var reader = new FileReader();

      //on lis le MIME
      var mime = file.type;
      console.log(mime);
      //IMAGE
      if (image.includes(mime)) {
        reader.onload = function(e) {
          document.getElementById('preview-img').src=e.target.result
        }
        reader.readAsDataURL(file);

        try{
          //on change l'appercu et le bouton
          var btn = document.getElementById('uploadbtn');
          btn.classList.add('btn-when-preview');
          var preview = document.getElementById('preview-img');
          preview.classList.remove('hidden');
          document.getElementById('preview-pdf').classList.add("hidden");
        }catch(error){}
      }
      //PDF
      else if(mime==pdf) {
        console.log("pdf");
        var previewName = document.getElementById("preview-pdf-name");
        previewName.innerHTML = file.name;

        //on change l'appercu et le bouton
        var btn = document.getElementById('uploadbtn');
        btn.classList.add('btn-when-preview');
        document.getElementById('preview-img').classList.add("hidden");
        document.getElementById('preview-pdf').classList.remove("hidden");
      }
      //CODE
      else if(code.includes(mime)) {
        console.log("code");
      }
      else{
        console.log("autre");
      }

  }
}

$("#file").change(function() {
  preview(this);
});