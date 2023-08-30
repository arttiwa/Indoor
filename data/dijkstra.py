

from graph import Graph

def dijkstra(graph, src, dest):
    shortest_paths = {src: (None, 0)}
    visited = set()

    while src != dest:
        visited.add(src)
        destinations = graph.edges[src]
        weight_to_src_node = shortest_paths[src][1]

        for next_node in destinations:
            weight = graph.weights[(src, next_node)] + weight_to_src_node
            if next_node not in shortest_paths:
                shortest_paths[next_node] = (src, weight)
            else:
                src_shortest_weight = shortest_paths[next_node][1]
                if src_shortest_weight > weight:
                    shortest_paths[next_node] = (src, weight)

        candidates = {node: shortest_paths[node] for node in shortest_paths if node not in visited}
        if not candidates:
            break
        src = min(candidates, key=lambda k: candidates[k][1])

    path = []
    while dest is not None:
        path.insert(0, dest)
        dest = shortest_paths[dest][0]

    return path
