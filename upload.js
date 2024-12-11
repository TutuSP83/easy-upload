let currentUser = null;

// Inicializa a página de upload
function initializeUploadPage() {
  const storedUser = localStorage.getItem('user');
  if (!storedUser) {
    alert('Você precisa fazer login primeiro.');
    window.location.href = 'index.html';
    return;
  }

  currentUser = JSON.parse(storedUser);
  document.getElementById('user-name').textContent = currentUser.username;
  loadFiles();
}

// Carrega os arquivos do usuário
async function loadFiles() {
  const fileList = document.getElementById('fileList');

  try {
    const response = await fetch(`http://localhost:3000/files/${currentUser.id}`);
    const files = await response.json();

    fileList.innerHTML = '';
    files.forEach(file => {
      const listItem = createFileItem(file.file_name, file.file_url, file.id);
      fileList.appendChild(listItem);
    });
  } catch (error) {
    console.error('Erro ao carregar arquivos:', error);
  }
}

// Faz o upload do arquivo
async function uploadFile() {
  const fileInput = document.getElementById('fileInput');
  const fileList = document.getElementById('fileList');

  if (fileInput.files.length > 0) {
    const file = fileInput.files[0];
    const formData = new FormData();
    formData.append('file', file);
    formData.append('userId', currentUser.id);

    try {
      const response = await fetch('http://localhost:3000/files', {
        method: 'POST',
        body: formData,
      });

      if (response.ok) {
        const newFile = await response.json();
        const listItem = createFileItem(newFile.file_name, newFile.file_url, newFile.id);
        fileList.appendChild(listItem);
        alert('Arquivo enviado com sucesso!');
      } else {
        alert('Erro ao enviar arquivo.');
      }
    } catch (error) {
      console.error('Erro ao enviar arquivo:', error);
    }
  } else {
    alert('Selecione um arquivo.');
  }
}

// Cria um item de arquivo na lista
function createFileItem(name, url, fileId) {
  const listItem = document.createElement('li');
  listItem.textContent = name;

  const downloadLink = document.createElement('a');
  downloadLink.href = url;
  downloadLink.textContent = 'Baixar';
  downloadLink.download = name;

  const deleteButton = document.createElement('button');
  deleteButton.textContent = 'Excluir';
  deleteButton.onclick = () => deleteFile(fileId, listItem);

  listItem.appendChild(downloadLink);
  listItem.appendChild(deleteButton);

  return listItem;
}

// Exclui um arquivo
async function deleteFile(fileId, listItem) {
  try {
    const response = await fetch(`http://localhost:3000/files/${fileId}`, {
      method: 'DELETE',
    });

    if (response.ok) {
      listItem.remove();
      alert('Arquivo excluído com sucesso.');
    } else {
      alert('Erro ao excluir arquivo.');
    }
  } catch (error) {
    console.error('Erro ao excluir arquivo:', error);
  }
}

// Sai da conta
function signOut() {
  localStorage.removeItem('user');
  alert('Você saiu da conta.');
  window.location.href = 'index.html';
}

// Inicializa a página ao carregar
initializeUploadPage();
