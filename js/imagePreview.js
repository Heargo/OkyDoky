function readURL(input) {

	if (input.files && input.files[0]) {
    	var reader = new FileReader();
    
    	reader.onload = function(e) {
      		document.getElementById('preview').src=e.target.result
    	}
    
   		reader.readAsDataURL(input.files[0]); // convert to base64 string
   		
      try{
        //on change l'appercu et le bouton
      var btn = document.getElementById('uploadbtn');
      btn.classList.add('btn-when-preview');
      var preview = document.getElementById('preview');
      preview.classList.remove('hidden');
    }catch(error){}
  }
}

$("#file").change(function() {
  readURL(this);
});