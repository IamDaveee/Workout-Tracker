<h1>Login successful</h1>
<p id="user-info">Loading user info...</p>

<script type="module">
    import { account } from './appwrite.js';

    async function loadUser() {
        try {
            const user = await account.get();
            document.getElementById('user-info').textContent =
                `Logged in as: ${user.email} (ID: ${user.$id})`;
        } catch (err) {
            console.error(err);
            document.getElementById('user-info').textContent =
                'Could not load user. Maybe you are not logged in.';
        }
    }

    loadUser();
</script>
