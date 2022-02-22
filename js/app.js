"use strict"

// ---------- API EXTERNA -------------------------

const perros = document.querySelector("#perros");

if(perros!==null){

  pintarDatos("https://dog.ceo/api/breeds/image/random/6");

  const crearFila = (imagen) => {
    const divPerros = document.createElement("div");
    divPerros.classList.add("col-12","col-md-5");

    const foto = document.createElement("img");
    foto.src = imagen;
    foto.classList.add("w-100","img-fluid");
    foto.style.height="500px";

    divPerros.appendChild(foto);

    return divPerros;
  }


  async function pintarDatos(url) {
    const respuesta = await fetch(url);
  
    const datos = await respuesta.json();
    const lista_perros = datos["message"];
    lista_perros.forEach(
      (perro) => {
        perros.appendChild(crearFila(perro));
      });
  }
}


//------------------- API INTERNA -------------------------------------

//TABLA
const tabla_noticias = document.querySelector("#lista_noticias");

//CARGA LAZY
let lazyImagenes={threshold:0};

const observer= new IntersectionObserver((entries,observer)=>{
  entries.forEach(
    (entry)=>{
      if(!entry.isIntersecting) return;
      const imagen=entry.target;
      const newURL= imagen.getAttribute("data-src");
      imagen.src=newURL;
      observer.unobserve(imagen);
    }
  );
}, lazyImagenes);


  const crearFila = (json) => {
    let noticia=document.createElement("article");
    noticia.classList.add("tarjetas");
    noticia.id = "ID_" + json["titulo"].toUpperCase().replaceAll(" ", "");
  
    //CREANDO ELEMENTOS
    let imagen = document.createElement("img");
    imagen.setAttribute("data-src",json["imagen"]);
    let tdImagen = document.createElement("div");
    tdImagen.appendChild(imagen);
    noticia.appendChild(tdImagen);
    observer.observe(imagen);
  
    let tdTitulo = document.createElement("h3");
    tdTitulo.innerText = json["titulo"];
    noticia.appendChild(tdTitulo);
  

    let tdFecha = document.createElement("span");
    const fechaEspanol=json["fecha_publicacion"].split("-");
    tdFecha.innerText = fechaEspanol[2]+"/"+fechaEspanol[1]+"/"+fechaEspanol[0];
  
    noticia.appendChild(tdFecha);
  

    let tdContenido = document.createElement("p");

    const contenidotxt=json["contenido"];

    let textdiv = contenidotxt.split(" ");
    let cortar = textdiv.length;

    if(cortar>20){
      for (let i = 0; i < 20; i++) {
        tdContenido.innerText += textdiv[i]+" ";
    }
      tdContenido.innerText += "...";
    }else{
      tdContenido.innerText = contenidotxt;
    }
  
  
    noticia.appendChild(tdContenido);
  
    let formulario=document.createElement("form");
    formulario.action="ficha_noticia.php";
    formulario.method="POST";
  
    let input_hidden=document.createElement("input");
    input_hidden.type="hidden";
    input_hidden.name="id";
    input_hidden.id="id";
    input_hidden.value=json["id"];
  
    let input_submit=document.createElement("input");
    input_submit.type="submit";
    input_submit.value="Ver más...";
  
    formulario.appendChild(input_hidden);
    formulario.appendChild(input_submit);
  
    noticia.appendChild(formulario);
    //================================================================================================
  
    return noticia;
  }

//SESIONES PARA EVITAR CONEXIÓN A BD
if(tabla_noticias!==null){
  if (sessionStorage.length === 0) {
    //PRIMERA CARGA

    (async () => {
      const respuesta = await fetch("../php/noticiaTabla.php");
      const datos = await respuesta.json();

      datos.forEach((noticia) => {
        sessionStorage.setItem("ID_" + noticia["titulo"].
          toUpperCase()
          .replaceAll(" ", ""),
          JSON.stringify(noticia))
      });
      //METER LOS DATOS EN LA TABLA LLAMANDO A crearFila
      Object.values(sessionStorage).forEach(
        (noticia) => {
          tabla_noticias.appendChild(crearFila(JSON.parse(noticia)));
        }
      )
    })();
    
  } else {
    //SESSION YA RELLENO
    Object.values(sessionStorage).forEach(
      (noticia) => {
        tabla_noticias.appendChild(crearFila(JSON.parse(noticia)));
      }
    )
  }
}