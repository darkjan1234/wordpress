public class Person
{
    public int PersonId { get; set; }

    [Required]
    [MinLength(2)]
    public string Name { get; set; }

    [Phone]
    public string PhoneNumber { get; set; }

    [EmailAddress]
    public string Email { get; set; }
}