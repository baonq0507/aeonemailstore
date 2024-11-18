
const request = (url, body, method) => {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            type: method,
            data: body,
            dataType: 'json',
            success: function (data) {
                resolve(data);
            },
            error: function (error) {
                reject(error);
            },
        });
    });
}

const get = async (url) => {
    return await request(url, null, 'GET');
}

const post = (url, body) => {
    return request(url, body, 'POST');
}

const put = (url, body) => {
    return request(url, body, 'PUT');
}

const del = (url) => {
    return request(url, null, 'DELETE');
}

const getUsers = async (url) => {
    if (!url) {
        url = 'https://jsonplaceholder.typicode.com/users';
    }
    const users = await get(url);
    const usersList = $('#usersList');
    users.forEach(user => {
        usersList.append(`<li>${user.name}</li>`);
    })
}
