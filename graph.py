class Graph:
    def __init__(self, graph):
        self.graph = graph
        self.edges = {node: set(graph[node].keys()) for node in graph}
        self.weights = {(node, next_node): graph[node][next_node] for node in graph for next_node in graph[node]}
