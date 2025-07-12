const categories = [
  {
    title: "Men's Wear",
    img: "images/image 1.jpg",
  },
  {
    title: "Women's Wear",
    img: "images/image 2.jpg",
  },
  {
    title: "Footwear",
    img: "images/image 3.jpg",
  },
  {
    title: "Kids Clothing",
    img: "images/image 4.jpg",
  },
  {
    title: "Winter Wear",
    img: "images/image 5.jfif",
  },
];

function renderCategories() {
  const categoryGrid = document.getElementById("categoryGrid");
  categories.forEach((cat) => {
    const card = document.createElement("div");
    card.className = "category-card";
    card.innerHTML = `
      <img src="${cat.img}" alt="${cat.title}" />
      <h3>${cat.title}</h3>
    `;
    categoryGrid.appendChild(card);
  });
}

renderCategories();
