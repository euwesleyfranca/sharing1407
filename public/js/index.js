async function hopeStoriesFilter() {
  const searchInput = document.querySelector("#sugests").value;
  const list = document.querySelector("#list");
  const charactersToSearch = 1;
  const amountOfCharacters = parseFloat(searchInput.length);

  if (searchInput) {
    if (amountOfCharacters >= charactersToSearch) {
      const searchValue = searchInput.toLowerCase();
      const data = await fetch("filter.php?value=" + searchValue);
      list.innerHTML = '';
      const users = await data.json();
      for (user of users.data) {
        list.innerHTML += `
        <li class="li">
              <figure>
                  <img src="${user.image}" alt="user" width="50" height="50" />
              </figure>${user.name}
          </li>
        `;
      }
    } else {
      const data = await fetch("filter.php?value=" + '');
      const users = await data.json();
      list.innerHTML = '';
      for (user of users.data) {
        list.innerHTML += `
        <li class="li">
              <figure>
                  <img src="${user.image}" alt="amor" width="50" height="50" />
              </figure>${user.name}
          </li>
        `;
      }
    }
  }
}
