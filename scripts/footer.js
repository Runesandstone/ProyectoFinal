const footerContainer = document.getElementById("footer-row");

const footerData = [
    {
        type: "div",
        class: "footer-links",
        content: [
            {
                type: "h4",
                content: "CETI Academy Library"
            },
            {
                type: "words",
                content: "Empoderando mentes mediante el conocimiento y recursos de aprendizaje."
            }
        ]
        
    },
    {
        type: "div",
        class: "footer-links",
        content: [
            {
                type: "h4",
                content: "Información de Contacto"
            },
            {
                type: "a",
                href: "https://cetiacademy.com",
                content: "Sitio CETI web oficial"
            },
            {
                type: "words",
                content: `Email: library@ceti.edu<br>Telefono: (123) 456-7890`
            },
        ]
    },
    {
        type: "div",
        class: "footer-links",
        content: [
            {
                type: "h4",
                content: "Síguenos"
            },
            {
                type: "a",
                href: "https://www.facebook.com/cetiacademy",
                content: "Facebook"
            },
            {
                type: "a",
                href: "https://www.twitter.com/cetiacademy",
                content: "Twitter"
            },
            {
                type: "a",
                href: "https://www.instagram.com/cetiacademy",
                content: "Instagram"
            }
        ]
    }   
];

for (const data of footerData) {
    
    const dataDiv = document.createElement(data.type);
    dataDiv.className = data.class || "footer-links";
    const header = document.createElement("h4");
    header.textContent = data.content[0].content; // Assuming the first content is always the header
    dataDiv.appendChild(header); 
    
    const list = document.createElement("ul");
    list.className = "footer-list"; // Add class for styling
    dataDiv.appendChild(list);


    for (const content of data.content) {
        const listElement = document.createElement("li");
        listElement.className = "footer-list-item"; // Add class for styling
        list.appendChild(listElement);

        if (content.type === "h4") continue; // Skip h4 as it's already handled
        if (content.type === "words") {
            const wordsElement = document.createElement("p");
            wordsElement.innerHTML = content.content;
            listElement.appendChild(wordsElement);
        } else {
            const element = document.createElement(content.type);
            element.textContent = content.content;
            if (content.href) {
                element.href = content.href;
            }
            listElement.appendChild(element);
        }
    }

    footerContainer.appendChild(dataDiv);
}