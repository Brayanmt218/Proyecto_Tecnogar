describe('Prueba de registro de usuario', () => {

    // Define los datos de un usuario de prueba como un objeto para mayor claridad y reutilización
    const getNewUserData = () => {
        const timestamp = Date.now();
        return {
            name: `Usuario Prueba ${timestamp}`,
            email: `testuser_${timestamp}@example.com`,
            password: 'Password123!', // Asegúrate que esta contraseña cumple con Rules\Password::defaults()
            password_confirmation: 'Password123!'
        };
    };

    // Función auxiliar para rellenar el formulario de registro
    const fillRegistrationForm = (userData) => {
        // Asegúrate de que los campos estén presentes y visibles antes de escribir
        // Usamos los atributos 'placeholder' para seleccionar los inputs, ya que son visibles en el HTML renderizado
        cy.get('input[placeholder="Full name"]').should('be.visible').type(userData.name);
        cy.get('input[placeholder="email@example.com"]').should('be.visible').type(userData.email);
        cy.get('input[placeholder="Password"]').should('be.visible').type(userData.password);
        cy.get('input[placeholder="Confirm password"]').should('be.visible').type(userData.password_confirmation);
    };

    // Función auxiliar para hacer clic en el botón de registro
    const clickRegisterButton = () => {
        cy.get('button[type="submit"]').contains('Create account')
          .closest('button') // Asegura que estamos haciendo clic en el elemento <button>
          .should('not.be.disabled') // Asegura que el botón no esté deshabilitado
          .should('be.visible')     // Asegura que el botón sea visible
          .click();
    };

    it('Debe registrar un nuevo usuario con éxito', () => {
        cy.visit('/register'); // Visita la página de registro
        // Espera a que el formulario de registro sea visible buscando el formulario y su botón de envío
        cy.get('form').should('be.visible').contains('button', 'Create account').should('be.visible');

        const userData = getNewUserData(); // Obtiene datos únicos para este test

        fillRegistrationForm(userData); // Rellena el formulario con los datos

        clickRegisterButton(); // Hace clic en el botón de registro

        // Verifica que la redirección después del registro fue exitosa
        cy.url().should('include', '/dashboard');
    });

    it('Debe mostrar errores de validación al intentar registrar sin datos', () => {
        cy.visit('/register'); // Visita la página de registro
        cy.get('form').should('be.visible').contains('button', 'Create account').should('be.visible'); // Espera a que la página cargue

        // Intenta enviar el formulario sin rellenar ningún campo
        clickRegisterButton();

        // Verifica los mensajes de error de validación (adapta si están en español)
        // Estos mensajes suelen aparecer bajo los campos, o en un modal si usas SweetAlert2 para errores de validación.
        // Si los mensajes están en inglés, asegúrate de que coincidan exactamente.
        cy.contains('The name field is required.').should('be.visible');
        cy.contains('The email field is required.').should('be.visible');
        cy.contains('The password field is required.').should('be.visible');
    });

    it('Debe mostrar error si las contraseñas no coinciden', () => {
        cy.visit('/register');
        cy.get('form').should('be.visible').contains('button', 'Create account').should('be.visible'); // Espera a que la página cargue

        const userData = getNewUserData();
        userData.password_confirmation = 'wrongpassword'; // Modifica la confirmación para que no coincida

        fillRegistrationForm(userData); // Rellena el formulario con los datos (incluyendo la contraseña incorrecta)

        clickRegisterButton();

        // Verifica el mensaje de error de que las contraseñas no coinciden (adapta si está en español)
        cy.contains('The password confirmation does not match.').should('be.visible');
    });

    it('Debe mostrar error si el email ya ha sido registrado', () => {
        // Paso 1: Registrar un usuario para asegurarnos de que el email exista
        const existingUserData = getNewUserData();
        cy.visit('/register');
        cy.get('form').should('be.visible').contains('button', 'Create account').should('be.visible'); // Espera a que la página cargue
        fillRegistrationForm(existingUserData);
        clickRegisterButton();
        cy.url().should('include', '/dashboard'); // Asegura que el primer registro fue exitoso

        // Paso 2: Intentar registrar con el mismo email
        cy.visit('/register'); // Vuelve a la página de registro
        cy.get('form').should('be.visible').contains('button', 'Create account').should('be.visible'); // Espera a que la página cargue
        const duplicateUserData = getNewUserData();
        duplicateUserData.email = existingUserData.email; // Usa el email ya registrado

        fillRegistrationForm(duplicateUserData); // Rellena el formulario con el email duplicado

        clickRegisterButton();

        // Verifica el mensaje de error de email duplicado (adapta si está en español)
        cy.contains('The email has already been taken.').should('be.visible');
    });

});