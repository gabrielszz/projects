
document.querySelector('.btn-cuidados').addEventListener('click', function(){
	// console.log("testew");
	// document.querySelector('.conteudo-cuidado-texto').innerHTML = "testando";
	//var h1 = createElement('h1');
	var btn = document.createElement("h1");   // Create a <button> element
	btn.innerHTML = "<p>Teste</p>";                   // Insert text
	document.querySelector('.cuidados-conteudo').appendChild(btn);   

	//var conteudo = "<h1>Mais um</h1><p>Teste</p>";
	var conteudo = '<span> O que é</span><p>Apendicite é a inflamação do'+
	' apêndice, um pequeno órgão parecido com o dedo de uma luva, localizado na primeira'+
	' porção do intestino grosso. Qualquer pessoa corre o risco de ter uma inflamação do'+
	' apêndice, o que, sem o tratamento adequado, pode levar a graves complicações. Em mulheres,'+
	' a inflamação das tubas uterinas, do útero ou dos ovários também provoca dor do lado direito do'+
	' abdômen, motivo pelo qual é preciso estabelecer o diagnóstico com auxílio de exames de imagem,'+
	' como ultrassom e tomografia.</p><span>Causas</span><p>As causas da apendicite não '+
		'são sempre claras, mas algumas situações são conhecidas por levar à inflamação no apêndice. Veja:'+
	' Obstrução por gordura ou fezes Infecção, como a gastrointestinal causada por vírus. Em ambos os casos,'+
	' uma bactéria presente naturalmente dentro do apêndice começa a se multiplicar, causando a inflamação e'+
	' o inchaço do apêndice, e eventualmente com pus. Se não tratada prontamente, a apendicite pode causar o '+
	'rompimento do apêndice.</p><h2 class="titulo">Sintomas</h2><p>O processo de inflamação tende a ser muito '+
	'rápido e pode durar por volta de 12 a 18 horas. As primeiras sensações de incômodo surgem ao redor do umbigo,'+
	' mas é comum que a dor se concentre no lado inferior direito do abdome. Devido à gravidade do quadro, é preciso'+
	' estar atento à dor, especialmente se ela começa fraca e difusa e vai se concentrando na parte inferior direita do abdome com o passar das horas. Apesar de ser mais comum em pessoas entre 10 e 30 anos, a apendicite pode acometer pessoas de qualquer idade, incluindo crianças e idosos, que geralmente têm mais dificuldade de identificar os sintomas. A sensação de desconforto e as consequências podem variar de acordo com cada indivíduo, mas, além da dor intensa, outros sintomas comuns são: <strong>Enjoo; perda de apetite; calafrios; febre; apatia; constipação; diarreia; distensão e rigidez abdominal.</strong>Devido à gravidade do quadro, é preciso estar atento à dor, especialmente se ela 	começa fraca e difusa e vai se concentrando na parte inferior direita do abdome com o passar das horas.</p><h2 class="titulo">Tratamento</h2><p>Após a confirmação do diagnóstico, o tratamento é exclusivamente cirúrgico, com a remoção do apêndice. A cirurgia deve ser realizada o mais rapidamente possível para evitar complicações, como a perfuração do apêndice e a inflamação da cavidade abdominal, pondo em risco a vida do paciente.</p>';
	document.querySelector('.cuidados-conteudo').innerHTML = conteudo;
	zeraBotoes();
	document.querySelector('.btn-cuidados2').classList.add("selecionado");
});

document.querySelector('.btn-cuidados2').addEventListener('click', function(){
	var conteudo = '<span>O que é</span><p>Refluxo gastroesofágico é o retorno involuntário e'+
	'repetitivo do conteúdo do estômago para o esôfago. Os alimentos mastigados na boca passam '+
	'pela faringe, pelo esôfago (um tubo que desce pelo tórax na frente da coluna vertebral) '+
	'e caem no estômago, situado no abdômen. Entre o esôfago e o estômago, existe uma válvula'+
	'que se abre para dar passagem aos alimentos e se fecha imediatamente para impedir que o '+
	'suco gástrico penetre no esôfago, pois a mucosa que o reveste não está preparada para receber '+
	'uma substância tão irritante. Crianças pequenas podem apresentar episódios de refluxo em virtude da '+
	'fragilidade dos tecidos existentes na transição entre o estômago e o esôfago. Na maioria dos casos, '+
	'o problema desaparece espontaneamente.</p><span>Causas</span><p>As causas mais comuns são:<BR>Alterações '+
	'no esfíncter que separa o esôfago do estômago e que deveria funcionar como uma válvula para impedir o retorno dos alimentos;'+
	'hérnia de hiato provocada pelo deslocamento da transição entre o esôfago e o estômago, que se projeta para dentro da cavidade'+
	' torácica; fragilidade das estruturas musculares existentes na região.</p>'+
	'<span>Sintomas</span><p>Os sintomas mais comuns são:'+
							'Azia ou queimação que se origina na boca do estômago, mas pode atingir a garganta;'+
							'dor torácica intensa, que pode ser confundida com a dor da angina e do infarto do miocárdio;'+
							'tosse seca;'+
							'doenças pulmonares de repetição, como pneumonias, bronquites e asma.</p>'+
				      	'<span>Tratamento</span>'+
							'<p>O tratamento pode ser clínico ou cirúrgico. O clínico inclui a administração de'+
							 'medicamentos que diminuem a produção de ácido pelo estômago e melhoram a motilidade do esôfago.'+
							  'Paralelamente, o paciente recebe orientação para perder peso, evitar alimentos e bebidas que agravam o quadro,'+
							   'fracionar a dieta, não se deitar logo após as refeições e praticar exercícios físicos. A cirurgia pode ser realizada'+
							    'de maneira convencional ou por laparoscopia e está indicada nos casos de hérnia de hiato, para os pacientes que não '+
							    'respondem bem ao tratamento clinico ou quando é necessário confeccionar uma válvula antirrefluxo. Ela é sempre um '+
							    'procedimento adequado, quando a repetição do refluxo gastroesofágico provoca esofagite grave, uma vez que a acidez do '+
							    'suco gástrico pode alterar as células do revestimento esofágico e dar origem a tumores malignos.</p>';
	document.querySelector('.cuidados-conteudo').innerHTML = conteudo;
	zeraBotoes();
	document.querySelector('.btn-cuidados2').classList.add("selecionado");
});

document.querySelector('.btn-cuidados3').addEventListener('click', function(){
	var conteudo = '<h2 class="titulo"> Oeeded que é</h2><p>Apendicite é a inflamação do apêndice, um pequeno órgão parecido com o dedo de uma luva, localizado na primeira porção do intestino grosso. Qualquer pessoa corre o risco de ter uma inflamação do apêndice, o que, sem o tratamento adequado, pode levar a graves complicações. Em mulheres, a inflamação das tubas uterinas, do útero ou dos ovários também provoca dor do lado direito do abdômen, motivo pelo qual é preciso estabelecer o diagnóstico com auxílio de exames de imagem, como ultrassom e tomografia.</p><h2 class="titulo">Causas</h2><p>As causas da apendicite não são sempre claras, mas algumas situações são conhecidas por levar à inflamação no apêndice. Veja: Obstrução por gordura ou fezes Infecção, como a gastrointestinal causada por vírus. Em ambos os casos, uma bactéria presente naturalmente dentro do apêndice começa a se multiplicar, causando a inflamação e o inchaço do apêndice, e eventualmente com pus. Se não tratada prontamente, a apendicite pode causar o rompimento do apêndice.</p><h2 class="titulo">Sintomas</h2><p>O processo de inflamação tende a ser muito rápido e pode durar por volta de 12 a 18 horas. As primeiras sensações de incômodo surgem ao redor do umbigo, mas é comum que a dor se concentre no lado inferior direito do abdome. Devido à gravidade do quadro, é preciso estar atento à dor, especialmente se ela começa fraca e difusa e vai se concentrando na parte inferior direita do abdome com o passar das horas. Apesar de ser mais comum em pessoas entre 10 e 30 anos, a apendicite pode acometer pessoas de qualquer idade, incluindo crianças e idosos, que geralmente têm mais dificuldade de identificar os sintomas. A sensação de desconforto e as consequências podem variar de acordo com cada indivíduo, mas, além da dor intensa, outros sintomas comuns são: <strong>Enjoo; perda de apetite; calafrios; febre; apatia; constipação; diarreia; distensão e rigidez abdominal.</strong>Devido à gravidade do quadro, é preciso estar atento à dor, especialmente se ela 	começa fraca e difusa e vai se concentrando na parte inferior direita do abdome com o passar das horas.</p><h2 class="titulo">Tratamento</h2><p>Após a confirmação do diagnóstico, o tratamento é exclusivamente cirúrgico, com a remoção do apêndice. A cirurgia deve ser realizada o mais rapidamente possível para evitar complicações, como a perfuração do apêndice e a inflamação da cavidade abdominal, pondo em risco a vida do paciente.</p>';
	document.querySelector('.cuidados-conteudo').innerHTML = conteudo;
	zeraBotoes();
	document.querySelector('.btn-cuidados3').classList.add("selecionado");
});

document.querySelector('.btn-cuidados4').addEventListener('click', function(){
	var conteudo = '<h2 class="titulo"> Oeeded que é</h2><p>Apendicite é a inflamação do apêndice, um pequeno órgão parecido com o dedo de uma luva, localizado na primeira porção do intestino grosso. Qualquer pessoa corre o risco de ter uma inflamação do apêndice, o que, sem o tratamento adequado, pode levar a graves complicações. Em mulheres, a inflamação das tubas uterinas, do útero ou dos ovários também provoca dor do lado direito do abdômen, motivo pelo qual é preciso estabelecer o diagnóstico com auxílio de exames de imagem, como ultrassom e tomografia.</p><h2 class="titulo">Causas</h2><p>As causas da apendicite não são sempre claras, mas algumas situações são conhecidas por levar à inflamação no apêndice. Veja: Obstrução por gordura ou fezes Infecção, como a gastrointestinal causada por vírus. Em ambos os casos, uma bactéria presente naturalmente dentro do apêndice começa a se multiplicar, causando a inflamação e o inchaço do apêndice, e eventualmente com pus. Se não tratada prontamente, a apendicite pode causar o rompimento do apêndice.</p><h2 class="titulo">Sintomas</h2><p>O processo de inflamação tende a ser muito rápido e pode durar por volta de 12 a 18 horas. As primeiras sensações de incômodo surgem ao redor do umbigo, mas é comum que a dor se concentre no lado inferior direito do abdome. Devido à gravidade do quadro, é preciso estar atento à dor, especialmente se ela começa fraca e difusa e vai se concentrando na parte inferior direita do abdome com o passar das horas. Apesar de ser mais comum em pessoas entre 10 e 30 anos, a apendicite pode acometer pessoas de qualquer idade, incluindo crianças e idosos, que geralmente têm mais dificuldade de identificar os sintomas. A sensação de desconforto e as consequências podem variar de acordo com cada indivíduo, mas, além da dor intensa, outros sintomas comuns são: <strong>Enjoo; perda de apetite; calafrios; febre; apatia; constipação; diarreia; distensão e rigidez abdominal.</strong>Devido à gravidade do quadro, é preciso estar atento à dor, especialmente se ela 	começa fraca e difusa e vai se concentrando na parte inferior direita do abdome com o passar das horas.</p><h2 class="titulo">Tratamento</h2><p>Após a confirmação do diagnóstico, o tratamento é exclusivamente cirúrgico, com a remoção do apêndice. A cirurgia deve ser realizada o mais rapidamente possível para evitar complicações, como a perfuração do apêndice e a inflamação da cavidade abdominal, pondo em risco a vida do paciente.</p>';
	document.querySelector('.cuidados-conteudo').innerHTML = conteudo;
	zeraBotoes();
	document.querySelector('.btn-cuidados4').classList.add("selecionado");
});


function zeraBotoes(){
	document.querySelector('.btn-cuidados').classList.remove("selecionado");
	document.querySelector('.btn-cuidados2').classList.remove("selecionado");
	document.querySelector('.btn-cuidados3').classList.remove("selecionado");
	document.querySelector('.btn-cuidados4').classList.remove("selecionado");
}
