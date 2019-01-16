const table = document.createElement('table');
const root = document.getElementById('root');

function onClick(event){
	if(this.getElementsByTagName('input').length > 0) return;
	const text = this.innerText;
	const input = document.createElement('input');
	input.addEventListener('blur', onBlur);
	input.value = text;
	this.innerText = "";
	this.appendChild(input);
	input.focus();
}

function onBlur(event){
	const value = this.value;
	const parent = this.parentNode;
	this.parentNode.removeChild(this);
	const text = document.createTextNode(value);
	parent.appendChild(text);
}

for (let i = 0; i<4; i++) {
	const tr = document.createElement('tr');
	table.appendChild(tr);

	if(i % 2 === 0) {
		tr.style.backgroundColor = "grey";
	}

	for (let j=0; j < 4; i++) {
		const td = document.createElement('td');
		const text = document.createTextNode('lorem ipsum');
		td.addEventListener('click', onClick);
		tr.appendChild(td);
		td.appendChild(text);
	}
}

root.appendChild(table);

