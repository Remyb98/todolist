### Project: Task Manager

**Description:**  
Develop a simple web application for task management (to-do list) using the Symfony framework. The application should allow a user to create, read, update, and delete tasks.

**Required Features:**
1. **Authentication:** Users should be able to register and log in to the application. Use Symfony's authentication system.
2. **Task Creation:** Authenticated users should be able to add new tasks with a title and description.
3. **Task List:** Display the list of tasks with the ability to mark a task as complete or incomplete.
4. **Task Update:** Users should be able to edit the details of an existing task.
5. **Task Deletion:** Users should be able to delete a task.
6. **Pagination System:** Paginate the list of tasks to avoid performance issues when the list becomes long.
7. **Validation:** Ensure that mandatory fields are validated server-side.
8. **User Interface:** A clean and user-friendly interface is important.

**Bonus (if time permits):**
1. **Task Filtering and Sorting:** Allow users to filter and sort tasks based on different criteria (e.g., by creation date, by status, etc.).
2. **Task Assignment:** Allow users to share tasks with other users of the system.
3. **Notifications:** Send notifications to users to remind them of upcoming tasks or overdue tasks.

**Technical Constraints:**
- Use Doctrine for database management.
- Use migrations to create necessary tables.
- Use Twig templates for the frontend.

**Evaluation Criteria:**
- Adherence to required features and technical constraints.
- Code structure: division into controllers, services, entities, etc.
- Correct use of Symfony best practices.
- Error and exception handling.
- Security: role and permission management.
- Quality of the user interface.
- Dependency management and dependency injection.

**Delivery:**
The developer must provide the source code of the application along with a quick installation guide.
