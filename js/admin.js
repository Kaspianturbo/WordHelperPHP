function setCurrentFile()
{
    var fileName = document.querySelector("#inputFile").value;
    var label = document.querySelector(".custom-file-label");
    label.innerHTML = fileName.split("\\").pop();
}

function validate()
{
    var fileName = document.querySelector("#inputFile").value;
    regex = new RegExp("(.*?)\.(docx)$");

    if (!(regex.test(fileName))) 
    {
        alert('Файл невірного формату. Завантажте в форму файл формату .docx');
        return false;
    }
}

function confirmAction()
{
    return result = confirm('Ви впевнені? Відмінити дію буде неможливо!');
}