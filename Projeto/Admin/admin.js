async function listarUsuarios() {
    try{
        const listaUsuarios = document.querySelector('.lista-usuarios');
        listaUsuarios.innerHTML = '';
        const resposta = await fetch('?action=listar');
        const dados = await resposta.json();
        if(dados.status =='sucesso'){
            dados.usuarios.forEach(usuario => {
                listaUsuarios.innerHTML +=`
                <div class='card-usuario'>
                    <p>Id: ${usuario.id_conta}</p>
                    <p>Nome: ${usuario.nome}</p>
                    <p>Email: ${usuario.email}</p>
                    <p>Tipo: ${usuario.tipo}</p>
                    <p>Data de criação: ${usuario.data_criacao}</p>
                    <div class="card-btn">
                    <button class="btn btn-editar"onclick="editarUsuario(${usuario.id_conta})">Editar</button>
                    <button class="btn btn-excluir" onclick="excluirUsuario(${usuario.id_conta})">Excluir</button><br><br>
                </div>
                `;
            });
        }else{
            window.alert('Erro ao buscar usuarios');
        }
    }catch(erro){
        window.alert('Erro ao buscar dados',erro);
    }
}


async function excluirUsuario(id_conta) {
    try{
        const resposta = await fetch('',{
            'method' : 'POST',
            'headers' : {'Content-type' : 'application/json'},
            'body': JSON.stringify({
                    action: 'excluir',
                    id_conta: id_conta
            })
        });

        const dados = await resposta.json();

        if(dados.status =='sucesso'){
            window.alert(dados.mensagem);
            listarUsuarios();
        }else{
            window.alert(dados.mensagem);
        }

    }catch(erro){
        window.alert('Erro ao excluir usuario',erro);
    }
}

async function editarUsuario(id_conta) {
    //fazer algo
}

addEventListener('DOMContentLoaded',listarUsuarios)