<script lang="ts">
    import Header from '@/components/Header.svelte';
    import AppHead from '@/components/AppHead.svelte';

    type Profile = {
        nom?: string;
        prenom?: string;
        email?: string;
        num_etudiant?: string;
        identifiant?: string;
        siret?: string,
        adresse?: string,
        code_postal?: string,
        ville?: string,
        pays?: string,
        num_tel?: string,
        type?: string,
    };
    let { profile }: { profile: Profile } = $props();
    let fields = [];
    if(profile?.type == '3'){
        fields = [
            { label: 'Nom', value: profile?.nom },
            { label: 'Prénom', value: profile?.prenom },
            { label: 'Email', value: profile?.email, full: true },
            { label: 'Numéro étudiant', value: profile?.num_etudiant },
            { label: 'Indentifiant', value: profile?.identifiant },
        ];
    }
    if(profile?.type == '2'){
        fields = [
            { label: 'Appelation', value: profile?.nom },
            { label: 'Email', value: profile?.email, full: true },
            { label: 'Indentifiant', value: profile?.identifiant },
            { label: 'siret', value: profile?.siret },
            { label: 'adresse', value: profile?.adresse },
            { label: 'code_postal', value: profile?.code_postal },
            { label: 'ville', value: profile?.ville },
            { label: 'pays', value: profile?.pays },
            { label: 'num_tel', value: profile?.num_tel },
        ];
    }
    
    function getFullName() {
        const prenom = profile?.prenom?.trim() ?? '';
        const nom = profile?.nom?.trim() ?? '';
        const value = `${prenom} ${nom}`.trim();
        return value !== '' ? value : 'Profil utilisateur';
    }

    function getInitials() {
        const parts = getFullName().split(/\s+/).filter(Boolean);
        const first = parts[0]?.[0] ?? 'P';
        const second = parts[1]?.[0] ?? '';
        return `${first}${second}`.toUpperCase();
    }

    function displayValue(value: string | null | undefined) {
        return value && value.trim() !== '' ? value : 'Non renseigné';
    }
</script>

<AppHead title="Profil" />

<Header/>
<main class="page-container">
    <div class="content">
        <p class="greeting">Bonjour, {getFullName()}</p>

        <div class="Y1">
            <div class="Bande">Mon profil</div>

            <div class="profile-header">
                <div class="avatar" aria-hidden="true">{getInitials()}</div>
                <p class="profile-name">{getFullName()}</p>
            </div>
        </div>
        <div class="Y2">
            <form>
                {#each fields as field, index}
                    <div class={`form-group ${field.full ? 'form-group-full' : ''}`.trim()}>
                        <label for={`profile-field-${index}`}>{field.label}</label>
                        <input id={`profile-field-${index}`} type="text" value={displayValue(field.value)} disabled />
                    </div>
                {/each}
            </form>

            <a class="back" href="/">← Retour à l'accueil</a>
        </div>
    </div>
</main>

<style>
    .greeting {
        margin: 0 0 14px;
        font-size: 26px;
        font-weight: 700;
        color: #0f172a;
    }

    .Bande {
        background-color: rgb(0, 102, 255);
        color: white;
        margin-bottom: 14px;
        padding: 26px 24px;
        font-size: 30px;
        font-weight: bold;
        border-radius: 10px;
    }


    .page-container {
        width: 100%;
        display: flex;
        min-height: 100vh;
        flex-direction: row;
        background: #f8fafc;
    }

    .content {
        width: 100%;
        padding: 24px;
        box-sizing: border-box;
    }

    .Y1,
    .Y2 {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 16px;
    }

    .Y1 {
        margin-bottom: 16px;
    }

    .Y2 input {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 16px;
    }

    .Y2 input:focus {
        border-color: #3498db;
        outline: none;
    }

    .Y2 form {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px 24px;
        align-items: flex-start;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group.form-group-full {
        grid-column: 1 / -1;
    }

    .form-group input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ced4da;
        border-radius: 6px;
        box-sizing: border-box;
        font-size: 15px;
        background-color: #fff;
        margin-bottom: 0;
    }

    .form-group input::placeholder {
        color: #6c757d;
        opacity: 1;
    }

    .profile-header {
        display: flex;
        align-items: center;
        gap: 16px;
        justify-content: flex-start;
    }

    .avatar {
        background: #0070f3;
        border: 2px solid #0070f3;
        color: #fff;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
    }

    .profile-name {
        margin: 0;
        font-weight: bold;
        font-size: 18px;
    }

    .back {
        display: inline-block;
        margin-top: 16px;
        text-decoration: none;
        color: #2563eb;
        font-weight: 600;
    }

</style>
