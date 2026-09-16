addEventListener('DOMContentLoaded',async()=>{
    try{
        const containerUsuarios = document.querySelector('.container-usuarios');
        const resposta = await fetch('?action=listar');
        const dados = await resposta.json();
        if(dados.status =='sucesso'){
            dados.usuarios.forEach(usuario => {
                containerUsuarios.innerHTML +=`
                <div class='container-usuario'>
                    <p>Id: ${usuario.id_conta}</p>
                    <p>Nome: ${usuario.nome}</p>
                    <p>Email: ${usuario.email}</p>
                    <p>Tipo: ${usuario.tipo}</p>
                    <p>Data de criação: ${usuario.data_criacao}</p>
                    <button id='btn-editar'>Editar</button>
                    <button id='btn-excluir'>Excluir</button><br><br>
                </div>
                `;
            });
        }else{
            window.alert('Erro ao buscar usuarios');
        }
    }catch(erro){
        window.alert('Erro ao buscar dados',erro);
    }
    

})