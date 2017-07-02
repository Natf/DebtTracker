import DebtCreator from './Modules/DebtCreator.js';

window.onload = () => {
    console.log('loading modules');
    let allModules = {
        "DebtCreator": DebtCreator
    };

    let modules = $('script[type="module"]');
    modules.each((index, module) => {
        let moduleName = $(module).attr('module-name');
        let moduleLoaded = new allModules[moduleName]();
        moduleLoaded.init();
        console.log('loading ' + $(module).attr('module-name'));
    });
};