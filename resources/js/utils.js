export function sortAndGroupClients(clientsArray) {
    const customOrder = [
        "newClient",
        "assessmentScheduled",
        "initialAssessment",
        "awaiting",
        "setup",
        "ongoing",
        "review",
        "yearly",
    ];

    let sortedClients = clientsArray.sort((a, b) => {
        const statusOrderDiff =
            customOrder.indexOf(a.client_status) -
            customOrder.indexOf(b.client_status);

        return statusOrderDiff !== 0
            ? statusOrderDiff
            : a.name.localeCompare(b.name);
    });

    return customOrder.reduce((acc, status) => {
        acc[status] = sortedClients.filter(
            (client) => client.client_status === status
        );
        return acc;
    }, {});
}
