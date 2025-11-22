@extends('layouts.app')

@section('content')
<h4>Admin - Manage Travels</h4>
<div id="alert"></div>

<button class="btn btn-primary mb-3" id="btnCreate">Create Travel</button>

<div id="list"></div>

<!-- Simple modal create/edit -->
<div class="modal" id="modalTravel" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content p-3">
      <h5 id="modalTitle">Create Travel</h5>
      <input id="t_title" class="form-control mb-2" placeholder="Title">
      <input id="t_date" type="date" class="form-control mb-2">
      <input id="t_time" type="time" class="form-control mb-2">
      <input id="t_quota" type="number" class="form-control mb-2" placeholder="Quota">
      <input id="t_price" type="number" class="form-control mb-2" placeholder="Price">
      <textarea id="t_desc" class="form-control mb-2" placeholder="Description"></textarea>
      <button id="saveTravel" class="btn btn-success">Save</button>
      <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
let editingId = null;
const listDiv = document.getElementById('list');

function loadList(){
    axios.get('/api/admin/travels').then(res=>{
        listDiv.innerHTML = '';
        res.data.forEach(t=>{
            const el = document.createElement('div');
            el.className = 'card p-2 mb-2';
            el.innerHTML = `<strong>${t.title}</strong> <br> ${t.departure_date} ${t.departure_time} <br> Quota: ${t.quota} | Price: ${t.price}
                <div class="mt-2">
                    <button class="btn btn-sm btn-warning" onclick="edit(${t.id})">Edit</button>
                    <button class="btn btn-sm btn-danger" onclick="del(${t.id})">Delete</button>
                </div>`;
            listDiv.appendChild(el);
        });
    });
}

function edit(id){
    axios.get('/api/admin/travels/' + id).then(res=>{
        const t = res.data;
        editingId = id;
        document.getElementById('t_title').value = t.title;
        document.getElementById('t_date').value = t.departure_date;
        document.getElementById('t_time').value = t.departure_time;
        document.getElementById('t_quota').value = t.quota;
        document.getElementById('t_price').value = t.price;
        document.getElementById('t_desc').value = t.description;
        document.getElementById('modalTitle').innerText = 'Edit Travel';
        new bootstrap.Modal(document.getElementById('modalTravel')).show();
    });
}

function del(id){
    if (!confirm('Delete?')) return;
    axios.delete('/api/admin/travels/' + id).then(()=>loadList());
}

document.getElementById('btnCreate').addEventListener('click', ()=>{
    editingId = null;
    document.getElementById('modalTitle').innerText = 'Create Travel';
    document.getElementById('t_title').value = '';
    document.getElementById('t_date').value = '';
    document.getElementById('t_time').value = '';
    document.getElementById('t_quota').value = '';
    document.getElementById('t_price').value = '';
    document.getElementById('t_desc').value = '';
    new bootstrap.Modal(document.getElementById('modalTravel')).show();
});

document.getElementById('saveTravel').addEventListener('click', function(){
    const payload = {
        title: document.getElementById('t_title').value,
        departure_date: document.getElementById('t_date').value,
        departure_time: document.getElementById('t_time').value,
        quota: document.getElementById('t_quota').value,
        price: document.getElementById('t_price').value,
        description: document.getElementById('t_desc').value,
    };
    if (editingId) {
        axios.put('/api/admin/travels/' + editingId, payload).then(()=>{ loadList(); bootstrap.Modal.getInstance(document.getElementById('modalTravel')).hide();});
    } else {
        axios.post('/api/admin/travels', payload).then(()=>{ loadList(); bootstrap.Modal.getInstance(document.getElementById('modalTravel')).hide();});
    }
});

document.addEventListener('DOMContentLoaded', loadList);
</script>
@endsection
