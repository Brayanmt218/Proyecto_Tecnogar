import { defineConfig } from "cypress";

export default defineConfig({
  e2e: {
    setupNodeEvents(on, config) {
      
    describe('Prueba de login', () => {

      it('Debe ingresar correctamente con credenciales válidas', () => {
        cy.visit('http://localhost:3000/login.html');
        cy.get('input[name=email]').type('admin@demo.com');
        cy.get('input[name=password]').type('123456');
        cy.get('button[type=submit]').click();
        cy.url().should('include', '/dashboard');
      });

      it('Debe mostrar error con credenciales incorrectas', () => {
        cy.visit('http://localhost:3000/login.html');
        cy.get('input[name=email]').type('fake@demo.com');
        cy.get('input[name=password]').type('wrongpass');
        cy.get('button[type=submit]').click();
        cy.contains('Credenciales inválidas');
      });

    });
        },
  },
});
