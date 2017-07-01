import {DebtCreator} from './Modules/DebtCreator.js'

window.onload = function() {
    var debtCreator = new DebtCreator()
    debtCreator.init();
    console.log('es5');
};