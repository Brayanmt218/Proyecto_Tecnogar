describe('Prueba de login', () => {

    it('La prueba del login se realizo de manera exitosa', () => {
        cy.visit('/login'); // <-- ¡Cambio aquí!
        cy.get('input[name=email]').type('ttitomariscalbrayan@gmail.com');
        cy.get('input[name=password]').type('123456789');
        cy.get('button[type=submit]').click();
        cy.url().should('include', '/dashboard');
    });

});