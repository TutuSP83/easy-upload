function uploadFile() {
  const fileInput = document.getElementById('fileInput');
  const fileList = document.getElementById('fileList');

  if (fileInput.files.length > 0) {
    const file = fileInput.files[0];
    const listItem = document.createElement('li');
    listItem.textContent = file.name;

    const downloadLink = document.createElement('a');
    downloadLink.href = URL.createObjectURL(file);
    downloadLink.textContent = 'Baixar';
    downloadLink.download = file.name;

    const deleteButton = document.createElement('button');
    deleteButton.textContent = 'Excluir';
    deleteButton.onclick = () => listItem.remove();

    listItem.appendChild(downloadLink);
    listItem.appendChild(deleteButton);
    fileList.appendChild(listItem);
  } else {
    alert('Selecione um arquivo.');
  }
}

function signOut() {
  window.location.href = '/';
}
