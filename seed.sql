CREATE TABLE article (
     id INT AUTO_INCREMENT PRIMARY KEY,
     title VARCHAR(255),
     content TEXT,
     created_at DATETIME,
     tags VARCHAR(255)
);

INSERT INTO article (title, content, created_at, tags)
VALUES (
   'The Importance of Sustainable Agriculture',
   'The Importance of Sustainable Agriculture

In today''s world, sustainable agriculture is not just a buzzword but a critical necessity. Our planet faces numerous challenges, including climate change, soil degradation, and a growing global population. Sustainable agriculture offers a path forward to address these challenges while ensuring the long-term health of our environment and food security.

Sustainable agriculture is an approach to farming that focuses on minimizing negative impacts on the environment, optimizing resource use, and providing economic viability for farmers. It encompasses a range of practices and principles aimed at achieving the following goals:

1. **Environmental Preservation**: Sustainable agriculture seeks to protect and enhance the natural environment. It promotes soil health, reduces the use of harmful chemicals, and conserves water resources. By maintaining biodiversity and healthy ecosystems, sustainable farming methods help mitigate the effects of climate change.

2. **Economic Viability**: Farmers are at the heart of sustainable agriculture. It is essential that farming practices are economically viable for farmers. Sustainable agriculture encourages fair pricing, diversification of income sources, and support for local communities. It helps farmers build resilience in the face of economic challenges.

3. **Food Security**: As the global population continues to grow, ensuring a stable and sufficient food supply is paramount. Sustainable agriculture practices improve food security by enhancing crop yields, reducing food waste, and promoting the use of locally adapted crops. It also supports small-scale farmers who play a crucial role in food production.

4. **Social Responsibility**: Sustainable agriculture places a strong emphasis on social responsibility. It promotes ethical labor practices, fair treatment of workers, and community engagement. It recognizes that farming communities are interconnected and that their well-being is integral to the success of sustainable agriculture.

5. **Innovation and Education**: Advancements in agricultural research and technology are vital for sustainable agriculture. This includes developing new farming techniques, improving crop varieties, and educating farmers about best practices. Sustainable agriculture encourages ongoing learning and adaptation.

In conclusion, sustainable agriculture is not just a choice; it''s a necessity for our planet''s future. By embracing sustainable practices, we can protect our environment, support farmers, ensure food security, and build a more resilient agricultural system. It''s a collective effort that requires the collaboration of governments, farmers, consumers, and the private sector. Together, we can create a more sustainable and prosperous future for all.
',
   '2023-09-28 16:45:00',
   'agriculture,sustainability,environment,farming'
);

INSERT INTO article (title, content, created_at, tags)
VALUES (
   'The Advantages of Renewable Energy Sources',
   'Renewable energy sources such as solar and wind power offer numerous advantages over fossil fuels...',
   '2023-09-29 12:30:00',
   'renewable energy,sustainability,climate change,green technology'
);

-- Insert an article about Healthy Eating Habits
INSERT INTO article (title, content, created_at, tags)
VALUES (
   'The Benefits of Healthy Eating Habits',
   'Maintaining a balanced diet with nutritious foods can lead to better overall health and well-being...',
   '2023-09-30 09:15:00',
   'nutrition,health,wellness,diet'
);

-- Insert an article about Artificial Intelligence
INSERT INTO article (title, content, created_at, tags)
VALUES (
   'Artificial Intelligence: Shaping the Future of Technology',
   'Artificial intelligence is revolutionizing various industries and driving technological advancements...',
   '2023-10-01 15:20:00',
   'artificial intelligence,technology,innovation,automation'
);

CREATE TABLE user (
      id INT AUTO_INCREMENT PRIMARY KEY,
      username VARCHAR(255) UNIQUE,
      password VARCHAR(255),
      pseudo VARCHAR(255)
);

INSERT INTO user (username, password, pseudo)
VALUES ('john_doe', '$john', 'JohnD');

