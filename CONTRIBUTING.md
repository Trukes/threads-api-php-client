# Contributing Guidelines

Thank you for considering contributing to this project! Below are the guidelines you should follow to ensure that your contributions can be efficiently integrated into the project.

## How to Contribute

### 1. Reporting Issues

If you find a bug or have a feature request, please open a new [Issue](link-to-issues). Try to include as much detail as possible:

- Clear description of the problem or suggestion.
- Steps to reproduce the issue (if applicable).
- PHP version and any other dependencies being used.

### 2. Submitting Pull Requests

If you'd like to fix a bug or implement a new feature, follow these steps:

1. **Fork** the repository.
2. **Clone** the repository to your local environment:
   ```bash
   git clone https://github.com/your-username/your-repository.git
   ```
3. Create a new branch for your changes:
   ```bash
   git checkout -b my-new-feature
   ```
4. Make your changes and commit them:
   ```bash
   git commit -m "Clear description of the change"
   ```
5. Push your changes to the remote repository:
   ```bash
   git push origin my-new-feature
   ```
6. Open a **Pull Request** detailing your changes and why they are necessary.

### 3. Code Standards

- **PSR-12**: Ensure your code follows the [PSR-12](https://www.php-fig.org/psr/psr-12/) coding standard.
- **Testing**: If you’re fixing a bug or adding a new feature, write automated tests to ensure the code behaves as expected.
- **Documentation**: Keep comments clear and add any necessary documentation for new features.

### 4. Running Tests

Before submitting your code, make sure all tests pass. You can run the tests using PHPUnit.

1. Install dependencies:
   ```bash
   composer install
   ```

2. Run the tests:
   ```bash
   ./vendor/bin/phpunit
   ```

Make sure all tests pass before submitting your Pull Request.

### 5. Commit Message Format

Follow this format for commit messages:

- `fix: description` for bug fixes.
- `feat: description` for new features.
- `docs: description` for documentation updates.
- `test: description` for changes related to tests.

### 6. Pull Request Review

Your Pull Request will be reviewed by the team. If changes are required, you will be notified, and you'll have the opportunity to address any issues identified.

## Thank You

Thank you for your interest in contributing! All types of contributions, whether reporting issues, suggesting improvements, or submitting code, are greatly appreciated.
