window.onload = () => {
  renderTable();
};

async function renderTable(page = 1, rowPerPage = 5) {
  const data = await getUser("", page, rowPerPage);
  let tableData = document.getElementById("table_data");
  $("#userModal").modal("hide");

  tableData.innerHTML = "";

  data.user.forEach((user, index) => {
    let tr = document.createElement("tr");

    let td = document.createElement("td");
    td.textContent =
      page == 1 ? index + page : (page - 1) * rowPerPage + index + 1;
    tr.appendChild(td);

    Object.keys(user).forEach((key) => {
      if (key != "id" && key != "password") {
        let td = document.createElement("td");
        td.textContent = user[key];
        tr.appendChild(td);
      }
    });

    let actionTd = document.createElement("td");

    let editButton = document.createElement("button");
    editButton.textContent = "Edit";
    editButton.classList.add("btn", "btn-success", "mr-2");
    editButton.setAttribute("data-toggle", "modal");
    editButton.setAttribute("data-target", "#userModal");
    editButton.onclick = () => updateUser(user.id);
    actionTd.appendChild(editButton);

    let deleteButton = document.createElement("button");
    deleteButton.textContent = "Delete";
    deleteButton.classList.add("btn", "btn-danger", "mr-2");
    deleteButton.onclick = () => deleteUser(user.id);
    actionTd.appendChild(deleteButton);

    tr.appendChild(actionTd);

    tableData.appendChild(tr);
  });

  renderPagination(data.totalPage, page, rowPerPage);
}

async function getUser(userId, page = 1, rowPerPage = 5) {
  const search = document.getElementById("inputSearch").value;
  const response = await fetch(
    `../service/userService.php?id=${userId}&page=${page}&rowPerPage=${rowPerPage}&search=${search}`,
    {
      method: "GET",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
    }
  );

  const data = await response.json();
  return data;
}

function createUser() {
  document.getElementById("inputPasswordUserContainer").style.display = "block";

  document.getElementById("formUser").addEventListener("submit", async (e) => {
    e.preventDefault();

    const response = await fetch(`../service/userService.php`, {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams({
        nama: document.getElementById("inputNamaUser").value,
        email: document.getElementById("inputEmailUser").value,
        password: document.getElementById("inputPasswordUser").value,
      }),
    });

    const data = await response.json();

    Swal.fire({
      title: data.message,
      icon: "info",
      confirmButtonText: "OK",
    });

    renderTable();
  });
}

function deleteUser(userId) {
  console.log(userId);
  Swal.fire({
    title: "Apakah anda yakin?",
    icon: "warning",
    showCancelButton: true,
    cancelButtonText: "Tidak",
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Ya",
  }).then(async (result) => {
    if (result.isConfirmed) {
      const response = await fetch("../service/userService.php", {
        method: "DELETE",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: new URLSearchParams({
          id: userId,
        }),
      });

      const data = await response.json();

      Swal.fire({
        title: data.message,
        icon: "info",
        confirmButtonText: "OK",
      });

      renderTable();
    }
  });
}

async function updateUser(userId) {
  let formUser = document.getElementById("formUser");
  let inputIdUser = document.getElementById("inputIdUser");
  let inputNamaUser = document.getElementById("inputNamaUser");
  let inputEmailUser = document.getElementById("inputEmailUser");
  let inputPasswordUser = document.getElementById("inputPasswordUserContainer");
  inputPasswordUser.style.display = "none";

  const data = await getUser(userId);
  const user = data.user;

  inputIdUser.value = user.id;
  inputNamaUser.value = user.nama;
  inputEmailUser.value = user.email;

  formUser.addEventListener("submit", async (e) => {
    e.preventDefault();

    const response = await fetch(`../service/userService.php`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams({
        id: inputIdUser.value,
        nama: inputNamaUser.value,
        email: inputEmailUser.value,
      }),
    });

    const data = await response.json();

    Swal.fire({
      title: data.message,
      icon: "info",
      confirmButtonText: "OK",
    });

    renderTable();
  });
}

function renderPagination(totalPages, currentPage, rowPerPage) {
  let pagination = document.getElementById("pagination");
  pagination.innerHTML = "";

  for (let i = 1; i <= totalPages; i++) {
    let li = document.createElement("li");
    li.classList.add("page-item");

    let a = document.createElement("a");
    a.classList.add("page-link");
    a.textContent = i;
    a.href = "#";
    a.onclick = () =>
      renderTable(i, document.getElementById("rowPerPage").value);

    if (i === currentPage) {
      li.classList.add("active");
    }

    li.appendChild(a);
    pagination.appendChild(li);
  }
}

document.getElementById("rowPerPage").addEventListener("change", () => {
  renderTable(1, document.getElementById("rowPerPage").value);
});

document.getElementById("inputSearch").addEventListener("keydown", () => {
  renderTable(1, document.getElementById("rowPerPage").value);
});
