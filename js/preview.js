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
      var preview_img = document.getElementById('preview-img');
      var preview_autre = document.getElementById('preview-autre');
      var preview_code = document.getElementById('preview-code');
      var preview_pdf =document.getElementById('preview-pdf');


      if(preview_autre==null){
        var onlyIMG=true;
      }else{
        var onlyIMG=false;
      }
      
      console.log(onlyIMG)
      //on lis le MIME
      var mime = file.type;
      console.log(mime);
      //IMAGE
      if (image.includes(mime) || onlyIMG) {
        reader.onload = function(e) {
          preview_img.src=e.target.result
        }
        reader.readAsDataURL(file);

        if (!onlyIMG){
          preview_pdf.classList.add("hidden");
          preview_autre.classList.add("hidden");
          preview_code.classList.add("hidden");
        }

        preview_img.classList.remove('hidden');
      }
      //PDF
      else if(mime==pdf) {
        console.log("pdf");
        var previewName = document.getElementById("preview-pdf-name");
        previewName.innerHTML = file.name;
        
        preview_img.classList.add("hidden");
        preview_autre.classList.add("hidden");
        preview_code.classList.add("hidden");
        preview_pdf.classList.remove("hidden");
      }
      //CODE
      else if(code.includes(mime)) {
        preview_code.dataset.src=window.URL.createObjectURL(file);
   
        preview_img.classList.add("hidden");
        preview_pdf.classList.add("hidden");
        preview_autre.classList.add("hidden");
        preview_code.classList.remove('hidden');
        Prism.highlightElement(preview_code);
      }
      else{
        console.log("autre");
        var previewName = document.getElementById("preview-autre-name");
        previewName.innerHTML = file.name;

        preview_img.classList.add("hidden");
        preview_pdf.classList.add("hidden");
        preview_code.classList.add("hidden");
        preview_autre.classList.remove("hidden");
      }
      try {
        //on change l'appercu et le bouton
        var btn = document.getElementById('uploadbtn');
        btn.classList.add('btn-when-preview');
      } catch(e) {}
      

  }
}

$("#file").change(function() {
  preview(this);
});