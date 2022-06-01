/**
 * A class which control the breweries import
 */
class ImportBreweries {
    constructor() {
        this.selectorButtonId = 'import-breweries';
        this.selectorListId = 'imported-breweries-list';
        this.addClickButtonEventListeners();

    }
    addClickButtonEventListeners() {
        const self = this;
        let element = document.getElementById(this.selectorButtonId);
        try {
            element.addEventListener("click", self.getApiResults.bind(self));
        } catch (error) {
            console.log(error);
        }
    }

    getApiResults() {
        let self = this;
        let pagesArray = [1, 2, 3];
        self.disableButtonAfterStartApi();
        Promise.all(pagesArray.map(id =>
            fetch(`https://api.openbrewerydb.org/breweries?page=${id}&per_page=25`)
                .then(response => response.json())
        )).then(dataArrays => {
            let newArray = dataArrays.reduce((list, sub) => list.concat(sub), []);
            console.log(newArray);
            let jsonString = JSON.stringify(newArray);
            self.sendAjaxDataBreweries(jsonString);

        });
    }
    sendAjaxDataBreweries(myDataJson) {
        let self = this;
        let headers = new Headers();
        let myAjaxParams = {
            method: 'POST',
            credentials: 'same-origin',
            headers: headers,
            body: new URLSearchParams({
                action: 'import_breweries_from_json',
                dataJson: myDataJson
            })
        }
        fetch(site_config_object.ajaxUrl, myAjaxParams)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                self.mountBreweriesList(data);
            });
    }

    mountBreweriesList(arrayList) {
        let self = this;
        let elementsArray = arrayList;
        let ulElement = document.getElementById(self.selectorListId);
        elementsArray.forEach(element => {
            let elementName = element.brewery_name;
            let elementWpUrl = element.brewery_wp_url;
            let elementEditUrl = element.brewery_edit_url;
            let liText = self.createHtmlElement(
                'p',
                elementName,
                [],
                ['brewery-name']
            );
            let liElement = self.createHtmlElement(
                'li',
                '',
                [],
                ['brewery-item']
            );
            let buttonContainer = self.createHtmlElement(
                'div',
                '',
                [],
                ['button-container']
            );
            let checkButton = self.createHtmlElement(
                'a',
                'Check brewery',
                [
                    ['href', elementWpUrl],
                    ['target', '_blank']
                ],
                ['button', 'button-primary']);
            let editButton = self.createHtmlElement(
                'a',
                'Edit brewery',
                [
                    ['href', elementEditUrl],
                    ['target', '_blank']
                ],
                ['button', 'button-secondary']);
            liElement.append(liText);
            buttonContainer.append(checkButton);
            buttonContainer.append(editButton);
            liElement.append(buttonContainer);
            setTimeout(function () {
                ulElement.append(liElement);
            }, 200)
        });
        // console.log(elementsArray);
    }

    createHtmlElement(elementString, text, attributes = [], classes = []) {
        let self = this;
        let elementToCreate = document.createElement(elementString);
        let elementAttributes = attributes;
        let elementClasses = classes;
        let elementText = text;
        elementToCreate.innerText = elementText;
        elementClasses.forEach(element => {
            elementToCreate.classList.add(element);
        });
        elementAttributes.forEach(element => {
            elementToCreate.setAttribute(element[0], element[1]);
        });
        return elementToCreate;
    }

    disableButtonAfterStartApi() {
        let self = this;
        let button = document.getElementById(self.selectorButtonId);
        button.setAttribute('disabled', 'disabled');
    }
}

new ImportBreweries();