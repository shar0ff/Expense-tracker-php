const userStatus = isAuthorized();
const isAdmin = false; // add later

const menuList = document.getElementById('menu-list');

// Always visible item
const homeItem = document.createElement('li');
homeItem.innerHTML = '<a href="../index.php">Home</a>';
menuList.appendChild(homeItem);

if (userStatus) {
    const categoriesItem = document.createElement('li');
    categoriesItem.innerHTML = '<a href="../pages/category-list">Categories</a>';
    menuList.appendChild(categoriesItem);

    const operationsItem = document.createElement('li');
    operationsItem.innerHTML = '<a href="#">Operations</a>';
    menuList.appendChild(operationsItem);

    const profileItem = document.createElement('li');
    profileItem.innerHTML = '<a href="#">Profile</a>';
    menuList.appendChild(profileItem);

    const logoutItem = document.createElement('li');
    profileItem.innerHTML = '<a href="../authorization/logout.php">Logout</a>';
    menuList.appendChild(profileItem);

    if (isAdmin) {
        const usersItem = document.createElement('li');
        usersItem.innerHTML = '<a href="#">Users</a>';
        menuList.appendChild(usersItem);
    }

} else {
    const loginItem = document.createElement('li');
    loginItem.innerHTML = '<a href="../pages/login.php">Login</a>';
    menuList.appendChild(loginItem);

    const SignupItem = document.createElement('li');
    loginItem.innerHTML = '<a href="../pages/register.php">Sign up</a>';
    menuList.appendChild(loginItem);
}