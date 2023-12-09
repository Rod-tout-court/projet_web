const removeItem = (e) => {
    console.log(e.target.closest(".item"));
    e.target.closest(".item").remove();
}


const newItem = (e) => {
    const collection_holder = document.querySelector(e.currentTarget.dataset.collection);
    const prototype = collection_holder.dataset.prototype;
    collection_holder.insertAdjacentHTML("beforeend",prototype.replace(/__name__/g, collection_holder.dataset.index));

    collection_holder.dataset.index++;
    collection_holder.querySelectorAll('.btn-remove').forEach(btn => btn.addEventListener('click', removeItem))
}

document.querySelectorAll(".btn-new").forEach(btn => btn.addEventListener('click', newItem))
document.querySelectorAll(".btn-remove").forEach(btn => btn.addEventListener('click', removeItem))