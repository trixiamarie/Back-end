const urlApi = 'http://localhost/EPICODE/Backend/Back-end/S3-L4/wordpress/wp-json/wp/v2/'
fetch(urlApi + 'posts')
.then(response => response.json())
.then(json =>{ 
    stampPosts(json),
    console.log(json)});

const container = document.querySelector('#posts');

function stampPosts(x){
    x.forEach(y => {
        const btn = document.createElement('button');
        btn.innerText= 'X';
        const idpost = y.id;
        btn.addEventListener('click', () => deletePost(idpost))
         const p = document.createElement('p');
        p.innerText = y.title.rendered;
        const p1 = document.createElement('div');
        p1.innerHTML = y.excerpt.rendered;
        container.appendChild(btn)
        container.appendChild(p);
        
        container.appendChild(p1);
    });
}

function deletePost(idpost){
    fetch(urlApi + 'posts/' + idpost, {
        method: 'DELETE'
    })
    .then(response => response.json())
    .then(json =>{ 
        console.log(json)});
    
}