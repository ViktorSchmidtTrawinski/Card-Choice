const formLogin = document.getElementById('form-box');

formLogin.addEventListener('submit',async (event)=>{
    event.preventDefault();

    const email = document.getElementById('email').value;
    const senha = document.getElementById('senha').value;

    try{
        const resposta = await fetch('',{
            'method': 'POST',
            'headers': {'Content-Type' : 'application/json'},
            'body': JSON.stringify({email:email,senha:senha})
        });
        const dados = await resposta.json();
        if(dados.status === 'sucesso'){
            alert(dados.mensagem);
            window.location.href='../Home/home.php';
        }else{
            alert(dados.mensagem);
        }
    }catch(e){
        console.log('Erro ao buscar dados ', e);
    }
})