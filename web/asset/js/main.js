/**
 *
 * @param id
 */
function openDir(id) {
    // id.innerHTML = "Ooops!";
    console.log(id.id);


    var dir = "";
    var sizeDir = 0;
    $.get("ajax?id=" + id.id, function (data) {
        for (d in data) {
            dir += data[d]['name'];
            dir += '<br>';
            sizeDir += data[d]['size'];

        }
        document.getElementById('dir').innerHTML = dir;
        document.getElementById('sizeDir').innerHTML = Math.round((sizeDir / 1024 / 1024) * 100) / 100;
    });
}