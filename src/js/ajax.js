const ajax= {
    call: function(url, method, data) {
        fetch(url, {
            method: method,
            body: JSON.stringify(data),
            headers: {
                "Content-type": "application/json; charset=UTF-8"
            }
        }).then(response => {
            if (!response.ok) {
                alert("HTTP-Error: " + response.status);
            }
        }).catch(error => {
            alert(error)
        });
    },

    get: function (url) {
        return fetch(url)
            .then(response => {
                if (!response.ok) {
                    alert("HTTP-Error: " + response.status);
                }
                return response;
            })
            .catch(error => {
                alert(error)
            });

    }
}