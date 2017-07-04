var neo4jQuery = window.neo4jQuery || {};
var neo4jQuery = function neo4jQuery(query, callback, url, auth) {
    $.ajaxSetup({
        headers: {
            // Add authorization header in all ajax requests
            // neo4jPW is "password" base64 encoded needs to be preencoded for a real release
            "Authorization": "Basic "+ auth
        }
    });

    $.ajax({
        type: "POST",
        url: url + "/db/data/transaction/commit",
        dataType: "json",
        contentType: "application/json;charset=UTF-8",
        data: JSON.stringify(query),
        success: function (data, textStatus, jqXHR) {
            callback(data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert("Connection to Database not possible");
        }
    });
}
window.neo4jQuery = neo4jQuery;