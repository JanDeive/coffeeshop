// Function to login and fetch users
const apiUrl = `${window.location.protocol}//${window.location.host}/php_oop`;

async function login() {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    const response = await fetch(`${apiUrl}/api/login`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ email, password })
    });

    const data = await response.json();
    if (response.ok) {
        // Store the token in localStorage (or sessionStorage)
        localStorage.setItem('jwt_token', data.token);
        alert('Login successful!');
        // Call function to fetch users after login
        fetchUsers();
    } else {
        alert(data.message || 'Login failed');
    }
}

// Function to fetch users
async function fetchUsers() {
    const token = localStorage.getItem('jwt_token');
    if (!token) {
        alert('You must be logged in to view users.');
        return;
    }

    const response = await fetch(`${apiUrl}/api/users`, {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json',
        }
    });

    const users = await response.json();
    if (response.ok) {
        const tableBody = document.getElementById('user-table-body');
        tableBody.innerHTML = ''; // Clear existing rows
        users.forEach((user, i) => {
            const row = document.createElement('tr');
            row.classList.add('border-b');
            row.innerHTML = `
                <td class="px-4 py-2">${++i}</td> 
                <td class="px-4 py-2">${user.username}</td>
                <td class="px-4 py-2">${user.email}</td>
                <td class="px-4 py-2"><img src="storage/images/${user.image_url}" alt="User Image" class="w-12 h-12 rounded-full"></td>
            `;
            tableBody.appendChild(row);
        });
    } else {
        alert('Failed to fetch users. Try to login');
    }
}

// Call fetchUsers
fetchUsers();
