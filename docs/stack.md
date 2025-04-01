Technical Choices

# Development Environment : Docker

https://docs.docker.com/manuals/

I’m using Docker mainly to practice a tool that’s widely used in the industry. It’s also great because it lets me avoid installing various versions of languages and tools directly on my computer, keeping my setup clean and manageable.

# Framework: Symfony

https://github.com/dunglas/symfony-docker

I chose Symfony for its stability and flexibility, which makes it great for building a wide range of applications. It's also widely used in the industry, which gives me a solid foundation for future projects.

# Database: PostgreSQL

I decided to use PostgreSQL because of its advanced features like partial indexes and its strong support for complex queries.

# Frontend: Tailwind CSS & Flowbite & HyperUI

https://tailwindcss.com/
https://flowbite.com/
https://www.hyperui.dev/

I chose Tailwind because of its utility classes and the high level of customization it offers. I can easily adjust the design to meet specific requirements without writing much custom CSS.
Flowbite & HyperUI complement Tailwind with pre-designed components that seamlessly integrate with Tailwind, saving time on developing standard UI elements like buttons, modals, and forms. I also use Flowbite for its interactive components, as it provides JavaScript functionality for elements like dropdowns, modals, and tooltips, eliminating the need to implement custom JS for these features.

# Build Tool: Vite.js

https://symfony-vite.pentatrion.com/

I opted for Vite.js as it's faster than Webpack and simpler to configure. It gives me more control over the setup, which is great for learning how asset imports work. It also makes it easier to integrate with other tools in the future.

# Email Handling: MailPit

https://github.com/axllent/mailpit

I chose MailPit because it’s integrated with Symfony and is perfect for testing email functionality locally without the risk of sending real emails.

# Version Control: Git

For version control, I am using Git, which is the industry-standard tool for tracking changes in code.

# Project Management : GitHub Project

https://docs.github.com/fr/issues/planning-and-tracking-with-projects

I’m using GitHub Projects for task and issue management. It helps keep track of progress and organizes tasks in a clear and efficient way.

# Automated dependency updates : Renovate

https://docs.renovatebot.com/
https://github.com/apps/renovate
https://developer.mend.io/

Dependencies can be a source of vulnerabilities. Renovate is an automated dependency update tool. It helps to update dependencies in the code without needing me to do it manually. It can create pull requests to update the versions automatically.
I use the the Mend Renovate App for ease of use.
