function adicionaCampo(){
	var campo = document.createElement("INPUT");
	campo.setAttribute("name", "arquivo[]");
	campo.setAttribute("type", "file");
	result.appendChild(campo);
}