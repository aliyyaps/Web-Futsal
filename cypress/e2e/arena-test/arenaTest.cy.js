import 'cypress-file-upload';


describe('Testing CRUD Arena', () => {
    it('User can read data', () => {
        cy.visit("http://127.0.0.1:8000/login")
        cy.get('#email').type("admin@admin.com")
        cy.get('#password').type("admin")
        cy.get('.btn').click()
        cy.get(':nth-child(4) > [data-toggle="collapse"]').click()
        cy.get('#ui-basic > .nav > :nth-child(1) > .nav-link').click()
        cy.get('.text').should("have.text", " New Arena ")
    })

    it('User Can Add Data', () => {
        cy.visit("http://127.0.0.1:8000/login")
        cy.get('#email').type("admin@admin.com")
        cy.get('#password').type("admin")
        cy.get('.btn').click()
        cy.get(':nth-child(4) > [data-toggle="collapse"]').click()
        cy.get('#ui-basic > .nav > :nth-child(1) > .nav-link').click()
        cy.get('.btn').click()
        cy.get('#nama').type("Nico Ganteng")
        cy.get('select').select("Vinyl")
        cy.get('#price').type("32000000")
        cy.get(':nth-child(5) > .form-control').attachFile("vinyle.jpg")
        cy.get('form > .btn').click()
    })

    it('User Can Edit Data', () => {
        cy.visit("http://127.0.0.1:8000/login")
        cy.get('#email').type("admin@admin.com")
        cy.get('#password').type("admin")
        cy.get('.btn').click()
        cy.get(':nth-child(4) > [data-toggle="collapse"]').click()
        cy.get('#ui-basic > .nav > :nth-child(1) > .nav-link').click()
        cy.get('.btn-info').click()
        cy.get('#nama').clear().type("Hello World")
        cy.get(':nth-child(7) > .form-control').attachFile("vinyle.jpg")
        cy.get('form > .btn').click()
    })

    it('User Can Delete Data', () => {
        cy.visit("http://127.0.0.1:8000/login")
        cy.get('#email').type("admin@admin.com")
        cy.get('#password').type("admin")
        cy.get('.btn').click()
        cy.get(':nth-child(4) > [data-toggle="collapse"]').click()
        cy.get('#ui-basic > .nav > :nth-child(1) > .nav-link').click()
        cy.get('.d-inline > .btn').click()
        cy.get(':nth-child(2) > .swal-button').click()
        cy.get(':nth-child(2) > .swal-button').click()
    })
})