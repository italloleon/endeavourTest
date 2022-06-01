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
        element.addEventListener("click", self.getApiResults.bind(self));
    }

    getApiResults() {
        let self = this;
        let pagesArray = [1, 2, 3];
        Promise.all(pagesArray.map(id =>
            fetch(`https://api.openbrewerydb.org/breweries?page=${id}&per_page=25`)
                .then(response => response.json())
        )).then(dataArrays => {
            let newArray = dataArrays.reduce((list, sub) => list.concat(sub), []);
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
            let liElement = document.createElement('li');
            let checkButton = document.createElement('a');
            let editButton = document.createElement('a');
            checkButton.innerText = 'Check post';
            editButton.innerText = 'Edit post';
            checkButton.classList.add('button', 'button-primary');
            editButton.classList.add('button', 'button-secondary');
            checkButton.setAttribute("href", elementWpUrl)
            liElement.innerText = elementName;
            liElement.append(checkButton);
            liElement.append(editButton);
            ulElement.append(liElement);
        });
        console.log(elementsArray);


    }
}

new ImportBreweries();