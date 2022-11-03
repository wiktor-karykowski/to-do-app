const checkbox = document.getElementById('icon');
const content = document.getElementById('content');

checkbox.addEventListener('change', e =>{
	if(e.target.checked === true){
		content.style.display = "none";
	}
	if(e.target.checked === false){
		content.style.display = "flex";
	}
});